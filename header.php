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
        <a href="/" class="nav__link <?= !is_category()
            ? "nav__link--active"
            : null ?>">All Resources</a>
      </li>
      <li class="nav__list-item">
        <a href="/category/advocacy-social-change/" class="nav__link <?= is_category(
            "advocacy-social-change"
        )
            ? "nav__link--active"
            : null ?>">Advocacy & Social Change</a>
      </li>
      <li class="nav__list-item">
        <a href="/category/environment-health/" class="nav__link <?= is_category(
            "environment-health"
        )
            ? "nav__link--active"
            : null ?>">Environment & Health</a>
      </li>
      <li class="nav__list-item">
        <a href="/category/history-arts-culture/" class="nav__link <?= is_category(
            "history-arts-culture"
        )
            ? "nav__link--active"
            : null ?>">History, Arts & Culture</a>
      </li>
      <li class="nav__list-item">
        <a href="/category/policy-planning/" class="nav__link <?= is_category(
            "policy-planning"
        )
            ? "nav__link--active"
            : null ?>">Policy & Planning</a>
      </li>
    </ul>
  </nav>