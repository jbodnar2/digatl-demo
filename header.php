<?php wp_head(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="parent-grid">
  <header class="header" aria-label="site">
    <div class="container flow-content">
      <h1 class="header__title">
        <a href="/"><span class="header__title--accent-text">digATL</span> | The Digital Atlanta Portal</a>
      </h1>
      <p class="header__tagline">
        Projects, collections, and data about the metro area produced by
        Georgia State University faculty, staff, and students working with and
        within their comunities
      </p>

      <form action="/" method="get" class="search">
        <button type="submit" class="search__button">Search</button>
        <input type="search" name="s" id="search" class="search__input" placeholder="Search resources by keyword"
          value="<?php the_search_query(); ?>" />
      </form>

    </div>
  </header>
  <nav class="nav" aria-label="primary">
    <ul class="nav__list container">
      <li class="nav__list-item">
        <a href="/" class="nav__link nav__link--active">All Resources</a>
      </li>
      <li class="nav__list-item">
        <a href="/" class="nav__link">Advocacy & Social Change</a>
      </li>
      <li class="nav__list-item">
        <a href="/" class="nav__link">Environment & Health</a>
      </li>
      <li class="nav__list-item">
        <a href="/" class="nav__link">History, Arts & Culture</a>
      </li>
      <li class="nav__list-item">
        <a href="/" class="nav__link">Policy & Planning</a>
      </li>
    </ul>
  </nav>