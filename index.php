<?php get_header(); ?>
<main class="main container" aria-label="content">
  <h2>All Resources</h2>
  <!-- Main content -->

  <div class="card-grid">

    <div class="card flow-content">

      <img loading="lazy" src="/wp-content/themes/digatl-demo/images/atl00.jpg" class="card__image" />
      <div class="card__categories">
        
        <?php the_category(" > "); ?>
      </div>
      <h3 class="card__title">
        The Sprawling of Atlanta: Visualizing Metropoitan Area Change, 1940s
        to the Present
      </h3>
      <p class="card__description">
        Interactive maps that visualize changes in the environment and
        demographics of the metropolitan area from the 1940s to the present.
        Explore aerial imagery overlays Lorem ipsum dolor sit amet
        consectetur adipisicing elit. Hic harum fugit pariatur.
      </p>

      <a href="/" class="card__info-link" data-dialog="dialog01">Read More</a>
      


      <div class="card__tags">
      <?php the_tags(
          '<img class="tags__image" src="/wp-content/themes/digatl-demo/images/tag.webp " alt=""> ',
          ", ",
          ""
      ); ?>
      </div>

        <a href="" class="card__resource-link button">Visit Resource</a>
      

    </div>

    <dialog id="dialog01" class="dialog flow-content">
      <h3 class="dialog__title">
        <a href="/" class="dialog__title-link">The Sprawling of Atlanta: Visualizing Metropoitan Area Change,
          1940s to the Present</a>
      </h3>
      <p class="dialog__description">
        Interactive web map created by Georgia State University Library that
        invites researchers, students, and the public to visualize the
        extensive built environment and demographic changes that have
        occurred throughout our metropolitan region from the 1940s to the
        present. The project provides aerial imagery overlays of the five
        core metropolitan counties – Fulton, DeKalb, Cobb, Gwinnett, and
        Clayton – documenting over eight decades of growth and change in our
        region. Also included are census tract level population and housing
        data, providing additional context to these visualizations. Among
        the changing patterns revealed are the dramatic growth of the
        suburbs, decline in agricultural areas, decline and rebuilding of
        the urban core, and shifting racial and housing patterns.
      </p>
      <dl class="flow-content">
        <div class="dl__group">
          <dt class="dl__title">Creators</dt>
          <dd>
            Project led by Joseph Hurley, Data Services and GIS Librarian,
            and Katheryn L. Nikolich, Ph.D. candidate in History, with
            assistance from GSU Honors College Student Assistant Carson
            Kantoris.
          </dd>
        </div>
        <div class="dl__group">
          <dt class="dl__title">Format</dt>
          <dd>ArcGIS Online</dd>
        </div>
        <div class="dl__group">
          <dt class="dl__title">Tagged</dt>
          <dd>
            <ul class="tags-list">
              <li class="tags-list__item">
                <a href="/" class="tags-list__link">tag a</a>
              </li>
              <li class="tags-list__item">
                <a href="/" class="tags-list__link">tag b</a>
              </li>
              <li class="tags-list__item">
                <a href="/" class="tags-list__link">tag c</a>
              </li>
            </ul>
          </dd>
        </div>
        <div class="dl__group">
          <dt class="dl__title">Category</dt>
          <dd>
            <a href="/" class="category-links">
              Advocacy & Social Change > Sub-Category</a>
          </dd>
        </div>
      </dl>
    </dialog>

  </div>

  <!-- Main Content End -->
</main>
<?php get_footer(); ?>
