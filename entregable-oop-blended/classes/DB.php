<?php

	abstract class DB
	{

				//4- AGREGAR LOS METODOS NECASARIOS EN LA CLASE DN PARA OBTENER TODOS LOS ACTORES
				//Y PARA GUARDAR UN ACTOR

				public static function getAllActors()
				{
					global $connection;

					$stmt = $connection->prepare("
								SELECT a.id , a.first_name, a.last_name, a.rating, a.favorite_movie_id, movies.title
								FROM actors as a
								left JOIN movies
								ON a.favorite_movie_id = movies.id
								ORDER BY a.first_name
					");

					$stmt->execute();
					$actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$actorsObject = [];

					foreach ($actors as $actor) {
						$finalActor = new Actor($actor['first_name'], $actor['last_name'], $actor['rating']);
						$finalActor->setFavorite_movie_id($actor['favorite_movie_id']);
						$finalActor->setId($actor['id']);

						$actorsObject[] = $finalActor;
						//var_dump($actorsObject);
					}
					return 	$actorsObject;
				}


				public static function saveActor(Actor $actor)
				{
					global $connection;

					try {
						$stmt = $connection->prepare("
							INSERT INTO actors (first_name, last_name, rating, favorite_movie_id)
							VALUES(:first_name, :last_name, :rating, :favorite_movie_id)
						");


						$stmt->bindValue(':first_name', $actor->getFirstName());
						$stmt->bindValue(':last_name', $actor->getLastName());
						$stmt->bindValue(':rating', $actor->getRating());
						$stmt->bindValue(':favorite_movie_id', $actor->getFavorite_movie_id());

						$stmt->execute();

						return true;
					} catch (PDOException $exception) {
						return false;
					}
				}


		public static function getAllMovies()
		{
			global $connection;

			$stmt = $connection->prepare("
				SELECT m.id AS 'movie_id', m.title, m.rating, m.awards, m.release_date, m.length, g.name AS 'genre', g.id AS 'genre_id'
				FROM movies as m
				LEFT JOIN genres as g
				ON g.id = m.genre_id
				ORDER BY m.title;
			");

			$stmt->execute();

			$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//var_dump($movies);exit;

			$moviesObject = [];

			foreach ($movies as $movie) {
				$finalMovie = new Movie($movie['title'], $movie['rating'], $movie['awards'], $movie['release_date']);
				//var_dump($finalMovie);
//2.	Corregir en el método getAllMovies la asignación de id de la película y el id del género
				$finalMovie->setLength($movie['length']);
				$finalMovie->setGenreID($movie['genre_id']);
				$finalMovie->setGenreName($movie['genre']);
				$finalMovie->setId($movie['movie_id']);


				$moviesObject[] = $finalMovie;
			}
			return $moviesObject;

		}



		public static function getAllGenres()
		{
			global $connection;

			$stmt = $connection->prepare(" SELECT id, name, ranking, active FROM genres");

			$stmt->execute();

			$genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$genresObject = [];

			foreach ($genres as $genre) {
				$finalGenre = new Genre($genre['name'], $genre['ranking'], $genre['active']);

				$finalGenre->setID($genre['id']);

				$genresObject[] = $finalGenre;
			}

			return $genresObject;
		}

		public static function saveMovie(Movie $movie)
		{
			global $connection;

			try {
				$stmt = $connection->prepare("
					INSERT INTO movies (title, rating, awards, release_date, length, genre_id)
					VALUES(:title, :rating, :awards, :release_date, :length, :genre_id)
				");


				$stmt->bindValue(':title', $movie->getTitle());
				$stmt->bindValue(':rating', $movie->getRating());
				$stmt->bindValue(':awards', $movie->getAwards());
				$stmt->bindValue(':release_date', $movie->getReleaseDate());
				$stmt->bindValue(':length', $movie->getLength());
				$stmt->bindValue(':genre_id', $movie->getGenreID());

				$stmt->execute();

				return true;
			} catch (PDOException $exception) {
				return false;
			}
		}

		public static function saveGenre(Genre $genre)
		{
			global $connection;

			$genres = self::getAllGenres();

			$finalGenres = [];

			foreach ($genres as $oneGenre) {
				$finalGenres[] = $oneGenre->getName();
			}

			if (!in_array($genre->getName(), $finalGenres)) {
				$stmt = $connection->prepare("
					INSERT INTO genres (name, ranking, active)
					VALUES(:name, :ranking, :active)
				");

				$stmt->bindValue(':name', $genre->getName());
				$stmt->bindValue(':ranking', $genre->getRanking());
				$stmt->bindValue(':active', $genre->getActive());

				$stmt->execute();

				return true;
			} else {
				return false;
			}
		}


		public function getMovieTitle($id)
		{
			global $connection;

			try {
				$stmt = $connection->prepare("
					SELECT movies.title FROM movies WHERE movies.id = $id;
				");

				$stmt->execute();
        $movie_title = $stmt->fetch(PDO::FETCH_ASSOC);
				return $movie_title['title'];
			} catch (PDOException $exception) {
				return false;
			}
		}
	}
