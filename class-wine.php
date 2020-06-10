<?php

class Wine{

	public $wine_id;
    public $picture;
    private $wine_info;
	private $ratings;

	function __construct($wine_id){
        $this->wine_id = $wine_id;
        /* 
        *
        * Get wine information from database and assign to correct variables
        *
        */
        require_once 'db_connect.php';//require_once instead of include so it will only add if not already included
        $mysqli = establish_connection();       
        $query = "SELECT * FROM wines WHERE wine_id = '$wine_id'";
        /**
         * Currently having issues with getting the ratings information. LEFT JOIN stops the query working
         * (e.g. adding "LEFT JOIN rating ON wines.wine_id = rating.wine_id"),
         * Works in a separate query (below), but that's not particularly resource efficient
         */
        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_row()) {
                $this->wine_info = array(
                    'wine_id' => $row[0],
                    'picture' => $row[1],
                    'name' => $row[2],
                    'brand' => $row[3],
                    'strength' => $row[4],
                    'volume' => $row[5],
                    'type' => $row[6],
                    'subtype' => $row[7],
                    'price' => $row[8],
                );
                /*if(isset($row[7])){//if ratings found
                    $this->ratings[] = array(
                        'rating_id' => $row[7],
                        'wine_id' => $row[8],
                        'ranker' => $row[9],
                        'comments' => $row[10],
                        'rating' => $row[11],
                    );
                }*/
            }
        }
        $query = "SELECT * FROM rating WHERE wine_id = '$wine_id'";
        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_row()) {
                $this->ratings[] = array( //Did this need []?
                    'rating_id' => $row[0],
                    'wine_id' => $row[1],
                    'comments' => $row[2],
                    'ranker' => $row[3],
                    'rating' => $row[4]
                );
            }
        }else{
        }
    }

    function get_wine_info(){
        return $this->wine_info;
    }

    function image(){//returns default img if none stored in database
        $image = ($this->wine_info['picture'] != NULL) ? $this->wine_info['picture'] : 'img.png';
        return $image;
    }

    function get_ratings(){
        $ratings = (isset($this->ratings)) ? $this->ratings : array();
        return $ratings;
    }
    
    function ratings_count(){
        return count($this->get_ratings());
    }
}