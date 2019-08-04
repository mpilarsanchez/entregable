<?php
//3. AGREGAR LA CLASE ACTOR CON SUS CORRESPONDIENTES ATRIBUTOS Y METODOS
class Actor
{
  private $id;
  private $first_name;
  private $last_name;
  private $rating;
  private $favorite_movie_id;


  public function __construct($first_name, $last_name, $rating)
  {
    $this->first_name = $first_name;
    $this->last_name = $last_name;
    $this->rating = $rating;

  }

  public function setFirstName($first_name)
  {
    $this->first_name = $first_name;
  }

  public function getFirstName()
  {
    return $this->first_name;
  }

  public function setLastName($last_name)
  {
    $this->last_name = $last_name;
  }

  public function getLastName()
  {
    return $this->last_name;
  }

  public function setRating($rating)
  {
    $this->rating = $rating;
  }

  public function getRating()
  {
    return $this->rating;
  }

  public function setFavorite_movie_id($favorite_movie_id)
  {
    $this->favorite_movie_id = $favorite_movie_id;
  }

  public function getFavorite_movie_id()
  {
    return $this->favorite_movie_id;
  }


  public function setId($id)
  {
    $this->id = $id;
  }

  public function getId()
  {
    return $this->id;
  }
}
 ?>
