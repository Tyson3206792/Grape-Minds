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
        $query = "SELECT * FROM wines LEFT JOIN rating ON wines.wine_id = rating.wine_id WHERE wines.wine_id = '$wine_id'";
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
										'comments' => $row[11],
										'rating' => $row[13],
                );
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
				$arr = $this->wine_info;
				if(is_null($arr['rating']))
        		return array_slice($this->wine_info, 0, 9);
				else {
						return $arr;
				}
    }

    function image(){//returns default img if none stored in database
        $image = ($this->wine_info['picture'] != NULL) ? $this->wine_info['picture'] : 'img.png';
        $image = "images/".$image;
        return $image;
    }

    function get_ratings(){
        $ratings = (isset($this->ratings)) ? $this->ratings : array();
        return $ratings;
    }

    function ratings_count(){
        return count($this->get_ratings());
    }

    function ratings_complete(){
        $count = $this->ratings_count();
        if($count >= 2){
            return true;
        }elseif($count == 1){
            $rating = $this->get_ratings();
            $rating = $rating[0];
            return ($rating['ranker'] == 'both') ? true : false;
        }
       return false;
    }

    function add_rating(){
        ?><form action="display_all.php" method="post">
        <label for="ranker">Rater: </label><select name="ranker" id="ranker">
            <option value="both">Both</option>
            <option value="Claire">Claire</option>
            <option value="Tyson">Tyson</option>
        </select>
        <label for="rating">Rating/10: </label><input type="number" name="rating" id="rating" min='0' max='10' step='0.25'>
        <label for="comments">Comments: </label><input type="text" name="comments" id="comments">
        <input type="hidden" name="wine_id" id="wine_id" value="<?php echo $this->wine_id; ?>">
        <input type="submit">
        </form><?php
    }
}
