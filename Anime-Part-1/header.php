<header class="p-3 bg-dark text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="<?php echo $domain; ?>" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <img class="bi me-2" height="50" role="img" aria-label="Bootstrap" src="<?php echo $domain; ?>/img/<?php echo $logo; ?>">
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="<?php echo $domain; ?>" class="nav-link px-2 text-white">HOME</a></li>
        <li><a href="<?php echo $domain; ?>/anime-list" class="nav-link px-2 text-white">ANIME LIST</a></li>
        <li><a href="<?php echo $domain; ?>/jadwal-rilis" class="nav-link px-2 text-white">JADWAL RILIS</a></li>
        <li><a href="<?php echo $domain; ?>/ongoing-anime" class="nav-link px-2 text-white">ON-GOING ANIME</a></li>
        <li><a href="<?php echo $domain; ?>/genre-list" class="nav-link px-2 text-white">GENRE LIST</a></li>
      </ul>

      <form action="<?php echo $domain; ?>/search" method="GET" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <div class="input-group mb-3">
          <input type="search" class="form-control" name="s" placeholder="Search..." aria-label="Recipient's username" aria-describedby="basic-addon2">
          <input type="search" style="display: none;" name="post_type" value="anime">
          <div class="input-group-append">
            <button class="btn btn-primary" style="margin-top: 5px;" type="submit">Search</button>
          </div>
        </div>
      </form>

        <!-- <div class="text-end">
          <button type="button" class="btn btn-outline-light me-2">Login</button>
          <button type="button" class="btn btn-warning">Sign-up</button>
        </div> -->
      </div>
    </div>
  </header>