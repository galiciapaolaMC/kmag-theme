<?php

/**
 * Template Name: Mulders Chart
 *
 * This template displays Mulders Chart information.
 *
 * @package CN
 */
?>

<?php get_header(); ?>

<main class="main-container mulders-chart-container" id="primary">
  <div class="background-gradient gradient-core-page position-top">
  </div>
  <div class="uk-container rl-content-wrapper rl-common">
    <div class="rl-top-section">
      <div class="rl-top-section__heading-wrapper">
        <?php the_title('<h1 class="hdg hdg--1"><a href="#overall">', '</a></h1>'); ?>
      </div>
    </div>
    <div>
      <section id="overall" class="section">
        <div class="row">
          <div class="md-4">
            <h3> </h3>
            <strong><?php _e('More is not always more!', 'kmag'); ?></strong>
            <p><?php _e('When it comes to soil fertility, a systems approach is the best way to achieve balanced crop nutrition. As Mulder’s Chart shows, when one nutrient is out of balance, it can impact the availability of other nutrients. Explore the chart to learn more.', 'kmag'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-1.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="antagonism" class="section">
        <div class="row">
          <div class="md-4">
            <h3> </h3>
            <p class="border-around-red"><?php _e('Despite their name, antagonistic nutrients don’t necessarily fight each other in the soil. Rather, they are similar in structure and characteristics in the soil, so when one is available in excess, the plant may have trouble finding other nutrients. In short, an oversupply of one nutrient can make other nutrients unavailable to the plant. ', 'kmag'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn disabled"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-2.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="synergism" class="section">
        <div class="row">
          <div class="md-4">
            <h3> </h3>
            <p class="border-around-green"><?php _e('With synergistic nutrients, nutrients are naturally complementary in the soil, working to make their counterparts available in the soil. For instance, ensuring the soil has the right level of nitrogen can unlock the soil’s natural supply of magnesium or molybdenum.'); ?></p>
            <a href="#antagonism" class="red-btn disabled"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-3.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="nitrogen" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Nitrogen (N)', 'kmag'); ?></h3>
            <p><?php _e('Nitrogen has both synergistic and antagonistic relationships with other nutrients. If nitrogen is overabundant in the soil, it can keep potash, copper and boron from being available to the plant. However, balanced levels of nitrogen can unlock sulfur, magnesium and molybdenum in the soil.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-4.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="phosphate" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Phosphate (P)', 'kmag'); ?></h3>
            <p><?php _e('Phosphate has primarily antagonistic relationships with other nutrients, and one synergistic relationship. If phosphate is overabundant in the sail, it can keep potash, calcium, zinc, iron and copper from being available to the plant. However, balanced levels of phosphate can unlock magnesium in the soil.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-5.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="potash" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Potash (K)', 'kmag'); ?></h3>
            <p><?php _e('Potash (potassium) has both synergistic and antagonistic relationships with other nutrients. If potash is overabundant in the soil, it can keep calcium, magnesium, boron, nitrogen and phosphate from being available to the plant. However, balanced levels of potash can unlock iron and manganese in the soil.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-6.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="sulfur" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Sulfur (S)', 'kmag'); ?></h3>
            <p><?php _e('Sulfur has both synergistic and antagonistic relationships with other nutrients. If sulfur is overabundant in the soil, it can keep calcium, copper and molybdenum from being available to the plant. However, balanced levels of sulfur can unlock manganese and nitrogen in the soil.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-7.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="calcium" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Calcium (Ca)', 'kmag'); ?></h3>
            <p><?php _e('Calcium does not have any synergistic relationships with other nutrients. If calcium is overabundant in the soil, it can keep magnesium, zinc, iron, manganese, boron, phosphate, potash and sulfur from being available to the plant. Rather than adding all of these other nutrients, be sure calcium is at the optimum level.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-8.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="magnesium" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Magnesium (Mg)', 'kmag'); ?></h3>
            <p><?php _e('Magnesium has both synergistic and antagonistic relationships with other nutrients. If magnesium is overabundant in the soil, it can keep potash and calcium from being available to the plant. However, balanced levels of magnesium can unlock nitrogen and phosphate in the soil.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-9.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="zinc" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Zinc (Zn)', 'kmag'); ?></h3>
            <p><?php _e('Zinc has only antagonistic relationships with other nutrients. If zinc is overabundant in the soil, it can keep iron, phosphate and calcium from being available to the plant.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-10.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="iron" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Iron (Fe)', 'kmag'); ?></h3>
            <p><?php _e('Iron has both synergistic and antagonistic relationships with other nutrients. If iron is overabundant in the soll, it can keep copper, manganese, phosphate, calcium and zinc from being available to the plant. Iron and potash have a synergistic relationship, meaning that balanced levels of either nutrient can unlock the other in the soil.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-11.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="copper" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Copper (Cu)', 'kmag'); ?></h3>
            <p><?php _e('Copper has primarily antagonistic relationships with other nutrients, and one synergistic relationship. If copper is overabundant in the soil, it can keep manganese, nitrogen, phosphate, sulfur and iron from being available to the plant. However, copper and molybdenum have a synergistic relationship, meaning that balanced levels of either nutrient can unlock the other in the soil.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-12.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="manganese" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Manganese (Mn)', 'kmag'); ?></h3>
            <p><?php _e('Manganese has both synergistic and antagonistic relationships with other nutrients. If manganese is overabundant in the soil, it can keep calcium, iron and copper from being available to the plant. However, manganese has a synergistic relationship with potash and sulfur, meaning that balanced levels of either nutrient can unlock the other in the soil.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-13.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="boron" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Boron (B)', 'kmag'); ?></h3>
            <p><?php _e('Boron has only antagonistic relationships with other nutrients. If boron is overabundant in the soil, it can keep nitrogen, potash and calcium from being available to the plant.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-14.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
      <section id="molybdenum" class="section">
        <div class="row">
          <div class="md-4">
            <h3><?php _e('Molybdenum (Mo)', 'kmag'); ?></h3>
            <p><?php _e('Molybdenum has an antagonistic relationship with sulfur, meaning that if it is overabundant in the soil, it can make sulfur unavailable. Molybdenum has a synergistic relationship with nitrogen and copper, meaning that when in balance, it can unlock those nutrients in the soil.'); ?></p>
            <a href="#antagonism" class="red-btn"><?php _e('Antagonism', 'kmag'); ?></a><br />
            <a href="#synergism" class="green-btn"><?php _e('Synergism', 'kmag'); ?></a>
          </div>
          <div class="md-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mulders-chart/mulders-chart-15.png" usemap="#workmap">
            <p class="chart-condition"><?php _e('Click the different nutrients to see their relationship with other nutrients in the soil.', 'kmag'); ?></p>
            <map name="workmap">
              <area shape="rect" coords="300,0,418,20" alt="nitrogen" href="#nitrogen">
              <area shape="rect" coords="82,45,245,65" alt="Molybdenum" href="#molybdenum">
              <area shape="rect" coords="478,43,612,65" alt="Phosphate" href="#phosphate">
              <area shape="rect" coords="82,117,175,137" alt="Boron" href="#boron">
              <area shape="rect" coords="552,117,650,137" alt="Potash" href="#potash">
              <area shape="rect" coords="0,215,150,235" alt="Manganese" href="#manganese">
              <area shape="rect" coords="572,215,660,235" alt="Sulfur" href="#sulfur">
              <area shape="rect" coords="60,313,175,333" alt="Copper" href="#copper">
              <area shape="rect" coords="552,313,670,333" alt="Calcium" href="#calcium">
              <area shape="rect" coords="160,385,245,405" alt="Iron" href="#iron">
              <area shape="rect" coords="478,385,640,405" alt="Magnesium" href="#magnesium">
              <area shape="rect" coords="315,430,405,450" alt="Zinc" href="#zinc">
            </map>
          </div>
        </div>
      </section>
    </div>
  </div>
  <div class="background-gradient gradient-core-page position-bottom">
  </div>
</main>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $("[href='#overall']").on("click", function(e) {
      e.preventDefault();
      $(".section").hide()
      $($(this).attr("href")).show()
    })
    $("[href='#antagonism']").on("click", function(e) {
      e.preventDefault();
      $(".section").hide()
      $($(this).attr("href")).show()
    })
    $("[href='#synergism']").on("click", function(e) {
      e.preventDefault();
      $(".section").hide()
      $($(this).attr("href")).show()
    })
    $("[name='workmap'] area").on("click", function(e) {
      e.preventDefault();
      $(".section").hide()
      $($(this).attr("href")).show()
    })
  })
</script>
<?php get_footer(); ?>