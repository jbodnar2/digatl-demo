<?php get_header(); ?>
<main class="main container" aria-label="content">
  <h2>All Resources</h2>
  <!-- Main content -->

  <div class="card-grid">

    <?php
    $temp = $wp_query;
    $wp_query = null;
    $wp_query = new WP_Query();
    $wp_query->query("showposts=9&post_type=resource" . "&paged=" . $paged);
    if ($wp_query->have_posts()):
        while ($wp_query->have_posts()):

            $wp_query->the_post();

            $resource_id = get_the_ID();

            $resource_url = esc_url(
                get_post_meta($resource_id, "resource_url", true)
            );

            $resource_creator = get_post_meta(
                $resource_id,
                "resource_creator",
                true
            );

            // Simply comma separated text list?
            // $resource_formats_array = get_the_terms($resource_id, "format");
            // $resource_format = join(
            //     ", ",
            //     wp_list_pluck($resource_formats_array, "name")
            // );

            // Linked list?
            $resource_format = get_the_term_list(
                $resource_id,
                "format",
                "<ul><li>",
                "</li><li>",
                "</li></ul>"
            );

            $resource_title = esc_attr(get_the_title());
            ?>
    <div class="card flow-content">

      <div class="card__top flow-content">
        <img loading="lazy" src="<?php echo get_the_post_thumbnail_url(); ?>" class="card__image" />
        
        <div class="card__categories">
          <?php the_category(" > "); ?>
        </div>
        
        <h3 class="card__title">

          <button class="card__title__info-button" data-dialog="dialog-<?= $resource_id ?>"> <?php the_title(); ?> </button>
          
        </h3>


        <div class="card__description">
          <?php echo get_the_excerpt(); ?>
        </div>

        <button class="card__info-button" data-dialog="dialog-<?= $resource_id ?>" title='Read more about <?= $resource_title ?>' aria-label="Read more about <?= $resource_title ?>">Read More &gt;</button>

        
      </div>
      
      <div class="card__bottom flow-content">
        
      <div class="card__tags">
          <?php the_tags(
              '<img class="tags__image" src="/wp-content/themes/digatl-demo/images/tag.webp " alt=""> ',
              ", ",
              ""
          ); ?>
        </div>

        <a href="<?= $resource_url ?>" aria-label="Visit <?= $resource_title ?>" title="Visit <?= $resource_title ?>" class="button button--block">Visit Resource</a>

        </div>
    </div>


    <dialog id="dialog-<?= $resource_id ?>" class="dialog flow-content">
      <h3 class="dialog__title">
        <a href="<?= $resource_url ?>" class="dialog__title-link"><?php the_title(); ?></a>
      </h3>
      <div class="dialog__description">
        
      <?php the_content(); ?>
        </div>
      <dl class="flow-content">
        <div class="dl__group">
          <dt class="dl__title">Creator</dt>
          <dd>
            <?= $resource_creator ?>
          </dd>
        </div>
        <div class="dl__group">
          <dt class="dl__title">Format</dt>
          <dd><?= $resource_format ?></dd>
        </div>
        <div class="dl__group">
          <dt class="dl__title">Tagged</dt>
          <dd>
            <?php the_tags("<ul><li>", "</li><li>", "</li></ul>"); ?>
          </dd>
        </div>
        <div class="dl__group">
          <dt class="dl__title">Category</dt>
          <dd>
            <?php the_category(); ?>
          </dd>
        </div>
      </dl>
    </dialog>


    <?php
        endwhile;
    endif;
    ?>
  </div>

  <nav style="display: flex; justify-content: flex-end;">
  <?php
  previous_posts_link("Previous");
  next_posts_link("Next");

  $wp_query = null;
  $wp_query = $temp;

  wp_reset_postdata();
  ?>
  </div>

  

  <!-- Main Content End -->
</main>
<?php get_footer(); ?>
