<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class Job extends Model{

        protected $table = 'jobs';
        protected $fillable = [
            'title',
            'description',
            'months',
            'logo'
        ];


        public function getDurationAsString(){
            if($this->months <= 12){
                return "$this->months months";
            }
            else{
                $years = floor($this->months / 12);
                $extraMonths = $this->months % 12;
                return "Job duration:$years years $extraMonths months";
            }
        }
        public function printElement($job){

            if($job['visible'] == false){
                return;
            }




        }



    }
?>
