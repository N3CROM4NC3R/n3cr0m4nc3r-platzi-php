<?php
    namespace App\Models;
    require_once('Printable.php');

    use Illuminate\Database\Eloquent\Model;

    class BaseElement extends Model implements Printable{


        public function getDurationAsString(){
            if($this->months <= 12){
                return "$this->months months";
            }
            else{
                $years = floor($this->months / 12);
                $extraMonths = $this->months % 12;
                return "$years years $extraMonths months";
            }
        }
    }
?>
