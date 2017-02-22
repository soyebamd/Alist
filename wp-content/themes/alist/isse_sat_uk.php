<div class="main-body">
    <div class="main-content">
        <?php
            get_template_part('sidebar');
        ?>
        <?php
            $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
            if(!$feat_image){
                $parents = get_post_ancestors( $post->ID );
                $pid = ($parents) ? $parents[count($parents)-1]: $post->ID;
                $feat_image = wp_get_attachment_url(get_post_thumbnail_id($pid));
            }
            if($feat_image){
        ?>
      <div class="clearfix"></div><!--clearfix-->
      <div class="inner-banner">
          <div class="inner-caption" style="background-image: url(<?php echo $feat_image;
          ; ?>)">
          </div><!--inner-caption-->
      </div><!--inner-banner-->
        <?php } ?>
      <div class="breadcrumb">
          <ul>
              <?php
                  if (function_exists('bcn_display')) {
                      bcn_display();
                  }
              ?>
          </ul>
      </div><!--breadcrumb-->
      <div class="clearfix"></div><!--clearfix-->
      <div class="inner-pages-content">
          <div class="container-content container-outer-wrap">
              <div class="isee-ssat-content container">
                  <h3><?php the_title(); ?></h3>
                  <?php the_content(); ?>
              </div>
          </div><!--inner-pages-content-->
          <div class="clearfix"></div><!--clearfix-->
      </div>
      <div class="container-content container-outer-wrap">
        <div class="container">
          <h4 class="red">We will help you by:</h4>
          <ul class="ul-arrow">
              <li >A-List has extensive experience working with students applying to US private high schools who are often required to take the ISEE or SSAT.</li>
              <li>Guiding high school selection</li>
              <li>Gathering key application materials</li>
              <li>Creating a checklist of requirements and deadlines></li>
              <li>Helping students create insightful application essays</li>
              <li>
                Conducting mock interviews to boost confidence and refine communication skills prior to interviews.
              </li>
          </ul>
          <p>A-List is committed to guiding both students and parents through the often daunting high school application process.</p>
          <div class="about-text">
            <h3 class="utility__left-text">About the Tests:</h3>
            <h5>ISEE (Independent School Entrance Exam)</h5>
            <p>The ISEE is a three-hour admission test for entrance into grades 5-12. The ISEE consists of carefully constructed and standardized verbal and quantitative reasoning tests that measure a student’s capability for learning, and reading comprehension and mathematics achievement tests that provide specific information about an individual’s strengths and weaknesses in those areas. All levels include a timed essay written in response to an assigned topic. The essay is not scored, but a copy is forwarded to the recipient schools along with the Individual Student Report, which shows scaled scores, percentiles, and stanines.The ISEE is given to students between grades 5-12 and includes Verbal Reasoning, Quantitative Reasoning, Reading Comprehension, and Mathematics Achievement. All four sections are given to each of the age groups with slight differentiations in emphasis between the lower, middle and high school levels of theexamination.<a href="http://www.erbtest.org/parents/admissions/isee">Learn more about the ISEE</a></p>
            <h5>SSAT (Secondary School Admission Test)</h5> 
            <p>The Secondary School Admission Test (SSAT) is given nationally several times a year or students may make individual arrangements to take it on other dates. The test consists of two parts: a brief essay and a multiple-choice aptitude test which measures your ability to solve mathematics problems, to use language, and to comprehend what you read. Scores depend only on the answers to the multiple choice questions; the results of the essay are sent to prospective schools to evaluate on their own.The test is administered to students in grades 5-11 and consists of five sections. You will be given 25 minutes for the writing sample, 40 minutes for the reading section, and 30 minutes each for the quantitative and verbal sections. All questions on the SSAT are equal in value, and scores are based on the number of questions you answer correctly minus one-quarter point for each question you answer incorrectly.<a href="http://www.ssat.org/publicsite.nsf/ssat/info/home">Learn more about the SSAT</a></p>
            <h5>SHSAT (Specialized High School Admissions Test)</h5>
            <p>Students in grades 8 or 9 who wish to apply to New York City’s Specialized high schools must take the Specialized High School Admissions Test (SHSAT) and submit an application listing their choices of schools in order of preference.The SHSAT is a timed multiple-choice test with two sections, verbal and math, that must be completed in a total of 2 hours and 30 minutes. In the first section, students demonstrate their verbal reasoning and reading comprehension by ordering sentences to form a coherent paragraph, answering questions of logical reasoning, and analyzing and interpreting texts. In the second section, students demonstrate their math skills by answering computational and word questions that require arithmetic, algebra, probability, statistics, geometry, and trigonometry (on the Grade 9 test only).<a href="http://schools.nyc.gov/Accountability/resources/testing/SHSAT.htm">Learn more about the SHSAT</a></p>
            <b>If you’re interested in working with A-List for ISEE/SSAT tutoring or high school admissions services, please complete our Enquiry form.</b> &nbsp;
            <div class="utility__pad-bump-top-btm-sm">
              <a class="default-btn" href="/uk/get-started/">Enquiry Form</a>
            </div>
          </div>
        </div>
      </div>      
      <?php get_template_part('map'); ?>
      <div class="clearfix"></div>
      <?php get_template_part('testimonials'); ?>
      <br /><?php
      edit_post_link(
              sprintf(
                      /* translators: %s: Name of current post */
                      __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
              ), '<span class="edit-link">', '</span>'
      );
      ?>
    </div><!--inner-page-content-->
</div><!--main-body-->
