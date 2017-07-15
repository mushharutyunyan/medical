<?php

namespace App\Models;

use App\Support\Arrays;
use Illuminate\Database\Eloquent\Model;
use File;
abstract class AbstractModel extends Model implements \JsonSerializable
{
    public function sync($relationship, $column, array $values)
    {

        $new_values = array_filter($values);
        $old_values = $this->$relationship->toArray();
        $old = array();
        foreach($old_values as $value){
            $old[$value[$column]] = $value['id'];
        }
        // Delete removed values, if any
        if ($deleted = Arrays::keysDeleted($new_values, $old)) {
            if($relationship == 'picture'){
                foreach ($deleted as $val){
                    $img = array_search($val,$old);
                    if(file_exists(public_path().'/assets/admin/images/drugs/'.$img)){
                        unlink(public_path().'/assets/admin/images/drugs/'.$img);
                    }
                }
            }
            $this->$relationship()->whereIn('id', $deleted)->delete();
        }

        // Create new values, if any
        if(!empty($old)){
            if ($created = Arrays::keysCreated($new_values, $old)) {
                if(empty($old)){
                    $created = $new_values;
                }
                foreach ($created as $value) {
                    $new[] = $this->$relationship()->getModel()->newInstance([
                        $column => $value,
                    ]);
                }
                $this->$relationship()->saveMany($new);
            }
        }else{
            if(!empty($new_values)){
                foreach ($new_values as $key => $value) {
                    $new[] = $this->$relationship()->getModel()->newInstance([
                        $column => $key,
                    ]);
                }
                $this->$relationship()->saveMany($new);
            }
        }
        // Update changed values, if any
//        if ($updated = Arrays::keysUpdated($new_values, $old)) {
//            foreach ($updated as $id) {
//                $this->$relationship()->find($id)->update([
//                    $column => $new_values[$id],
//                ]);
//            }
//        }
    }

    public function toArray()
    {
        $attributes = $this->attributesToArray();

        return array_merge($attributes, $this->relationsToArray());
    }
}
