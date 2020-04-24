<?php
    namespace App\Models;
    // require_once('BaseElement.php');

    class Project extends BaseElement{

        protected $table = 'projects';

        public function printElement(){
            echo'<div class="project">';
            echo'<h5>'.$this->title.'</h5>';
            echo'<div class="row">';
            echo'<div class="col-3">';
            echo'<img id="profile-picture" src="css/a.png" alt="">';
            echo'</div>';
            echo'<div class="col">';
            echo"<p>$this->description</p>";
            echo'<strong>Technologies used:</strong>';

            
            echo"</div>";
            echo"</div>";
            echo"</div>";
        }
    }
?>
