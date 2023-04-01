<?php
include 'conn.php';
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}

$sql = "SELECT id, title,description,deadline,complete FROM tbltasks";
$result = $conn->query($sql);
$conn->close(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Task Reminder App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
</head>

<body>
  <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
      <h1 class="navbar-brand">Web Service Programming Course</h1>
      <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          Welcome, <?= $_SESSION['username'] ?>
        </button>
        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
          <li><a class="dropdown-item" href="../Pertemuan3 - Latihan3/logout.php">Log out</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <br>
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="task-tab" data-bs-toggle="tab" data-bs-target="#task" type="button" role="tab" aria-controls="task">Task</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="movie-tab" data-bs-toggle="tab" data-bs-target="#movie" type="button" role="tab" aria-controls="movie">Movie</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade" id="task" role="tabpanel" aria-labelledby="task-tab">
      <br>
      <div class="container-fluid">
        <div class="row align-items-start">
          <div class="col">
            <h5>List Task</h5>
          </div>
          <div class="col">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Add Task</button>
              <!-- Modal -->
              <form action="insert.php" method="post">
                <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Insert Task List</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row mb-3">
                          <div class="col-sm-10">
                            <input required type="hidden" class="form-control" id="inputID" name="inputID" value="<?php echo $rows['id'] ?>">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputTask" class="col-sm-2 col-form-label">Task</label>
                          <div class="col-sm-10">
                            <input required type="text" class="form-control" id="inputTask" name="inputTask">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputDesc" class="col-sm-2 col-form-label">Description</label>
                          <div class="col-sm-10">
                            <input required type="text" class="form-control" id="inputDesc" name="inputDesc">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputDate" class="col-sm-2 col-form-label">Deadline</label>
                          <div class="col-sm-10">
                            <input required type="date" class="form-control" id="inputDate" name="inputDate">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputCom" class="col-sm-2 col-form-label">Complete</label>
                          <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                              <input required class="form-check-input" type="radio" id="inlineCheckbox1" value="Y" name="status">
                              <label class="form-check-label" for="inlineCheckbox1">Y</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input required class="form-check-input" type="radio" id="inlineCheckbox1" value="N" name="status">
                              <label class="form-check-label" for="inlineCheckbox1">N</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" name="insert">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <br />
      <div class="container-fluid">
        <!-- Content here -->
        <table class="table table-bordered table-hover table-responsive ">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Task</th>
              <th scope="col">Description</th>
              <th scope="col">Deadline</th>
              <th scope="col">Complete</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // LOOP TILL END OF DATA
            while ($rows = $result->fetch_assoc()) { ?>
              <tr>
                <td scope="row"><?php echo $rows['id']; ?></td>
                <td><?php echo $rows['title']; ?></td>
                <td><?php echo $rows['description']; ?></td>
                <td><?php echo $rows['deadline']; ?></td>
                <td><?php echo $rows['complete']; ?></td>
                <td>
                  <div class="d-md-flex justify-content">
                    <button class="btn btn-secondary me-md-2" type="button" data-bs-toggle="modal" data-bs-target="#edit<?php echo $rows['id'] ?>">Edit</button>
                    <!-- Modal Edit-->
                    <form action="update.php" method="post">
                      <div class="modal fade" id="edit<?php echo $rows['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Update Task List</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row mb-3">
                                <div class="col-sm-10">
                                  <input type="hidden" class="form-control" id="inputID" name="inputID" value="<?php echo $rows['id'] ?>">
                                </div>
                              </div>
                              <div class="row mb-3">
                                <label for="inputTask" class="col-sm-2 col-form-label">Task</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="inputTask" name="inputTask" value="<?php echo $rows['title'] ?>">
                                </div>
                              </div>
                              <div class="row mb-3">
                                <label for="inputDesc" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="inputDesc" name="inputDesc" value="<?php echo $rows['description'] ?>">
                                </div>
                              </div>
                              <div class=" row mb-3">
                                <label for="inputDate" class="col-sm-2 col-form-label">Deadline</label>
                                <div class="col-sm-10">
                                  <input type="date" class="form-control" id="inputDate" name="inputDate" value="<?php echo strftime('%Y-%m-%d', strtotime($rows['deadline'])) ?>">
                                </div>
                              </div>
                              <div class=" row mb-3">
                                <label for="inputCom" class="col-sm-2 col-form-label">Complete</label>
                                <div class="col-sm-10">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="inlineCheckbox1" value="Y" <?php echo ($rows['complete'] == 'Y') ? 'checked' : '' ?> name="status">
                                    <label class="form-check-label" for="inlineCheckbox1">Y</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="inlineCheckbox1" value="N" <?php echo ($rows['complete'] == 'N') ? 'checked' : '' ?> name="status">
                                    <label class="form-check-label" for="inlineCheckbox1">N</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-success" name="update">Update</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                    <!-- End Modal Edit-->
                    <!-- Button delete trigger modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#del<?php echo $rows['id'] ?>">
                      Delete
                    </button>
                    <form action="delete.php" method="post">
                      <!-- Start delete Modal -->
                      <div class="modal fade" id="del<?php echo $rows['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row mb-3">
                                <div class="col-sm-10">
                                  <input type="hidden" class="form-control" id="inputID" name="inputID" value="<?php echo $rows['id'] ?>">
                                </div>
                              </div>
                              <h5 class="text-center text-bold">Are you sure delete this data?</h5>
                              <h5 class="text-center text-danger"><?php echo $rows['id'] ?> - <?php echo $rows['title'] ?> : <?php echo $rows['description'] ?></h5>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-success" name="delete">Yes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- End delete Modal -->
                    </form>
                  </div>
                </td>
              </tr>
          </tbody>
        <?php
            }
        ?>
        </table>
        <br>
      </div>
      <br />
    </div>
    <div class="tab-pane fade show active " id="movie" role="tabpanel" aria-labelledby="movie-tab">
      <br>
      <div class="container-fluid">
        <div class="row align-items-start">
          <div class="col">
            <h5>In Theaters Movie</h5>
          </div>
        </div>
      </div>
      <br />
      <div class="container-fluid">
        <!-- Content here -->
        <div class="table-responsive">
          <table class="table table-bordered table-hover ">
            <thead>
              <tr>
                <th scope="col">ID Movie</th>
                <th scope="col">Title</th>
                <th scope="col">Year</th>
                <th scope="col">Release</th>
                <th scope="col">Poster</th>
                <th scope="col">Duration</th>
                <th scope="col">Plot</th>
                <th scope="col">Rating</th>
                <th scope="col">Genres</th>
                <th scope="col">Director</th>
                <th scope="col">Stars</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $movie_limit = 4;
              $moviepage = isset($_GET['moviepage']) ? (int)$_GET['moviepage'] : 1;
              $offset = ($moviepage - 1) * $movie_limit;
              $previous_movie = $moviepage - 1;
              $next_movie = $moviepage + 1;
              $curl = curl_init();

              curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://imdb-api.com/en/API/InTheaters/?apiKey=k_2abua645',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
              ));

              $response = curl_exec($curl);
              curl_close($curl);
              $respons = json_decode($response, true);
              $total_item = count($respons['items']);
              $total_moviepage = ceil($total_item / $movie_limit);

              // LOOP TILL END OF DATA
              for ($i = $offset; $i < $offset + $movie_limit; $i++) {
                if (isset($respons['items'][$i])) { ?>
                  <tr>
                    <td scope="row"><?php echo $respons['items'][$i]['id']; ?></td>
                    <td><?php echo $respons['items'][$i]['title']; ?></td>
                    <td><?php echo $respons['items'][$i]['year']; ?></td>
                    <td><?php echo $respons['items'][$i]['releaseState'] ?></td>
                    <td><img src="<?php echo $respons['items'][$i]['image'] ?>" alt="movie_poster" width="100" height="100"></td>
                    <td><?php echo $respons['items'][$i]['runtimeStr'] ?></td>
                    <td><?php echo $respons['items'][$i]['plot'] ?></td>
                    <td><?php echo $respons['items'][$i]['imDbRating'] ?></td>
                    <td><?php echo $respons['items'][$i]['genres'] ?></td>
                    <td><?php echo $respons['items'][$i]['directors'] ?></td>
                    <td><?php echo $respons['items'][$i]['stars'] ?></td>
                  </tr>
            </tbody>
          <?php
                }
          ?>
        <?php
              }
        ?>
          </table>
          <nav>
            <ul class="pagination justify-content-end">
              <li class="page-item">
                <a class="page-link" <?php if ($moviepage > 1) {
                                        echo "href='?moviepage=$previous_movie'";
                                      } ?>>Previous</a>
              </li>
              <?php
              for ($x = 1; $x <= $total_moviepage; $x++) {
              ?>
                <li class="page-item"><a class="page-link" href="?moviepage=<?php echo $x ?>"><?php echo $x; ?></a></li>
              <?php
              }
              ?>
              <li class="page-item">
                <a class="page-link" <?php if ($moviepage < $total_moviepage) {
                                        echo "href='?moviepage=$next_movie'";
                                      } ?>>Next</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <br />
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>