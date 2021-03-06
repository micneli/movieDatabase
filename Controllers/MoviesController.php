<?php
//include_once ob_start();

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class MoviesController
 * @mixin
 */
class MoviesController extends Controller
{
  /**
   * MoviesController constructor
   */
  public function __construct()
  {
    parent::__construct();
    $this->model = new MoviesModel();

    self::$_twig = parent::getTwig();
  }

    public function index() {
      $allMovies = $this->model->getAllMovies();
      $pageTwig = 'Movies/allMovies.html.twig';
      $template = self::$_twig->load($pageTwig);
      echo $template->render(["allMovies" => $allMovies]);
    }

    public function showMovie(int $id) {
      $actorsDetails = $this->model->getActorsDetails($id);
      $movieDetails = $this->model->getMovieDetails($id);
      $pageTwig = 'Movies/showMovie.html.twig';
      //self::$_twig->addGlobal('actor', $result);
      $template = self::$_twig->load($pageTwig);
      echo $template->render(["actorsDetails" => $actorsDetails, "movieDetails" => $movieDetails]);
    }

    public function addMovie() {
      // Fetch all directors and genres from the database into two dropdown lists on the Add Movie page
      $directors = $this->model->getAllDirectors();
      $genres = $this->model->getAllGenres();
      // Display the input form on the Add Movie page
      $pageTwig = 'Movies/addMovie.html.twig';
      $template = self::$_twig->load($pageTwig);
      echo $template->render(["directors" => $directors, "genres" => $genres]);
    }

    public function insertNewMovie() {
      $title = $_POST['title'];
      $release_year = $_POST['release_year'];
      $poster = $_FILES['poster']['name'];
      $poster_temp = $_FILES['poster']['tmp_name'];
      $synopsis = $_POST['synopsis'];
      $genre_id = $_POST['genre_id'];
      $director_id = $_POST['director_id'];

      move_uploaded_file($poster_temp, "Uploads/posters/$poster");

      $this->model->insertMovie($title, $release_year, $poster, $synopsis, $genre_id, $director_id);

      // if($this->model->insertMovie($titre, $annee_sortie, $synopsis, $genre, $director))
      // {
      //   echo "ok";
      // } else {
      //   echo "pas ok";
      //   echo $_POST['director'] . '<br>';
      //   echo $_POST['titre'] . '<br>';
      //   echo $_POST['annee_sortie'] . '<br>';
      //   echo $_POST['synopsis'] . '<br>';
      //   echo $_POST['genre'];
      // }

      header("Location: http://localhost/PHP_OOP_movieDB");
    }

    public function getAllMovies() {
      $getAllMovies = $this->model->getAllMovies();
      $pageTwig = 'Movies/getAllMovies.html.twig';
      $template = self::$_twig->load($pageTwig);
      echo $template->render(["getAllMovies" => $getAllMovies]);
    }

    // Function to fetch all the data from the DB into the Update Movie form on the Update Movie page
    public function getMovie($id_film) {
      $movieDetails = $this->model->getMovieDetails($id_film);
      $director = $this->model->getDirectorDetails($id_film);
      $directors = $this->model->getAllOtherDirectors($id_film);

      $genre = $this->model->getGenre($id_film);
      $genres = $this->model->getAllOtherGenres($id_film);

      $pageTwig = 'Movies/getMovie.html.twig';
      $template = self::$_twig->load($pageTwig);
      echo $template->render(["movieDetails" => $movieDetails, 'director' => $director, 'directors' => $directors, 'genre' => $genre, 'genres' => $genres]);
    }

    public function updateMovie($movie_id) {
      //if isset $_FILES so change poster if not, don't touch this information
      $title = $_POST['title'];
      $release_year = $_POST['release_year'];
      $poster = $_FILES['poster']['name'];
      $poster_temp = $_FILES['poster']['tmp_name'];
      $synopsis = $_POST['synopsis'];
      $genre_id = $_POST['genre_id'];
      $director_id = $_POST['director_id'];

      //supprimer l'affiche associé au film précédemment 
      move_uploaded_file($poster_temp, "Uploads/posters/$poster");

      $this->model->updateMovie($movie_id, $title, $release_year, $poster, $synopsis, $genre_id, $director_id);

      header("Location: http://localhost/PHP_OOP_movieDB");
    }
}