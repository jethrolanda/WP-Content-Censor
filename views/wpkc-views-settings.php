<?php
// check user capabilities
if (!current_user_can('manage_options')) {
    return;
}?>
<div class="wrap">
  <h1><?php echo __('Censor Keyword Settings', 'wp-keyword-censor'); ?></h1>

  <form method="post">
    <table class="form-table">
      <tbody>
        <tr>
          <th><label for=""><?php echo __('Keywords:', 'wp-keyword-censor'); ?></label></th>
          <td>
            <textarea name="wpkc_keywords" id="" cols="100" rows="10" placeholder="<?php echo __('Ex: Pussy | Dog', 'wp-keyword-censor'); ?>"></textarea>
            <p class="description"><?php echo __('Note: This will only censor words that is saved in the database and will not include the hard coded text in theme or plugin files.', 'wp-keyword-censor'); ?></p>
          </td>
        </tr>
        <tr>
          <th><label for=""><?php echo __('Matching:', 'wp-keyword-censor'); ?></label></th>
          <td>
            <fieldset>
              <label><input type="radio" name="wpkc_matching" checked> <?php echo __('Match the exact keyword', 'wp-keyword-censor'); ?></label><br>
              <label><input type="radio" name="wpkc_matching"> <?php echo __('Match only part of the word or phrase', 'wp-keyword-censor'); ?></label><br>
            </fieldset>
          </td>
        </tr>
        <tr>
          <th><label for=""><?php echo __('Content to filter:', 'wp-keyword-censor'); ?></label></th>
          <td>
            <fieldset>
              <label for="wpkc_content_to_filter">
              <input name="wpkc_content_to_filter" id="wpkc_content_to_filter_title" type="checkbox" class="" value="1" checked="checked"> <?php echo __('Title', 'wp-keyword-censor'); ?>
              </label>
            </fieldset>
            <fieldset>
              <label for="wpkc_content_to_filter">
              <input name="wpkc_content_to_filter" id="wpkc_content_to_filter_content" type="checkbox" class="" value="1" checked="checked"> <?php echo __('Content', 'wp-keyword-censor'); ?>
              </label>
            </fieldset>
            <fieldset>
              <label for="wpkc_content_to_filter">
              <input name="wpkc_content_to_filter" id="wpkc_content_to_filter_comments" type="checkbox" class="" value="1" checked="checked"> <?php echo __('Comments', 'wp-keyword-censor'); ?>
              </label>
            </fieldset>
          </td>
        </tr>
        <tr>
          <th><label for=""><?php echo __('Post types:', 'wp-keyword-censor'); ?></label></th>
          <td>
            <fieldset>
              <label for="wpkc_post_types_post">
              <input name="wpkc_post_types_post" id="wpkc_post_types_post" type="checkbox" class="" value="1" checked="checked"> <?php echo __('Post', 'wp-keyword-censor'); ?>
              </label>
            </fieldset>
            <fieldset>
              <label for="wpkc_posty_types_page">
              <input name="wpkc_posty_types_page" id="wpkc_posty_types_page" type="checkbox" class="" value="1" checked="checked"> <?php echo __('Page', 'wp-keyword-censor'); ?>
              </label>
            </fieldset>
          </td>
        </tr>
        <tr>
          <th><label for=""><?php echo __('Keyword Rendering', 'wp-keyword-censor'); ?></label></th>
          <td>
            <fieldset>
              <label><input type="radio" name="wpkc_keyword_rendering" checked> <?php echo __('Replace all words (ex. Cloudy = ******)', 'wp-keyword-censor'); ?></label><br>
              <label><input type="radio" name="wpkc_keyword_rendering"> <?php echo __('Exclude first letter (ex. Cloudy = C*****)', 'wp-keyword-censor'); ?></label><br>
              <label><input type="radio" name="wpkc_keyword_rendering"> <?php echo __('Exclude first and last letter (ex. Cloudy = C****y)', 'wp-keyword-censor'); ?></label><br>
            </fieldset>
          </td>
        </tr>
        <tr>
          <th><label for=""><?php echo __('Replace keywords with:', 'wp-keyword-censor'); ?></label></th>
          <td>
            <input name="wpkc_replace_keywords_with" id="wpkc_replace_keywords_with" type="text" placeholder="*" style="width: 400px" maxlength="1">
            <p class="description"><?php echo __('Note: If left blank, will use asterisk (*) as default. Only 1 character limit is allowed.', 'wp-keyword-censor'); ?></p>
          </td>
        </tr>
        <tr>
          <th><label for=""><?php echo __('Apply the changes on the following users:', 'wp-keyword-censor'); ?></label></th>
          <td>
            <fieldset>
              <label for="wpkc_apply_changes_on_the_following_users_logged_in">
              <input name="wpkc_apply_changes_on_the_following_users_logged_in" id="wpkc_apply_changes_on_the_following_users_logged_in" type="checkbox" class="" value="1" checked="checked"> <?php echo __('Logged-in', 'wp-keyword-censor'); ?>
              </label>
            </fieldset>
            <fieldset>
              <label for="wpkc_apply_changes_on_the_following_users_logged_out">
              <input name="wpkc_apply_changes_on_the_following_users_logged_out" id="wpkc_apply_changes_on_the_following_users_logged_out" type="checkbox" class="" value="1" checked="checked"> <?php echo __('Loggout-out', 'wp-keyword-censor'); ?>
              </label>
            </fieldset>
          </td>
        </tr>
      </tbody>
    </table>

    <?php

submit_button('Save Settings');?>
    <!-- <p class="submit">
      <button name="save" class="button-primary woocommerce-save-button" type="submit"><?php echo __('Save changes', 'wp-keyword-censor'); ?></button>
    </p> -->
  </form>
</div>
