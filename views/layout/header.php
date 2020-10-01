<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
                <span class="icon-bar"></span> <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><img src="/assets/media/logo.png" alt="" style="max-height:100px;"/></a>
        </div>

<?php
if ($app->isLoggedIn()) {
    echo "
      <div id='navbar' class='collapse navbar-collapse'>
        <ul class='nav navbar-nav'>
          <li><a href='/'>Home</a></li>
          <li><a href='/user/profile/'>Update Profile</a></li>
         ";


    echo "
          <li class='dropdown'>
            <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Collections <span class='caret'></span></a>
            <ul class='dropdown-menu'>
              <li><a href='/booking/request'>New Collection Request</a></li>
            </ul>
          </li>
          <li><a href='/login/logout'>Log Out</a></li>
          <li><a href='#'>
            ";
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SESSION['user']['role_id']) && php_uname("n") == "STO-WRK-098") {
        echo 'Currently logged in as role ID ' . $_SESSION['user']['role_id'];
    }
    echo "</a>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse -->
      ";
}
echo "
  </div>
</nav>
";
