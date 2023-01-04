<div class="wrap">
  <h1>Censor Keywords Settings</h1>

  <form method="post">
    <table class="form-table">
      <tbody>
        <tr>
          <th><label for="">Keywords:</label></th>
          <td>
            <textarea name="" id="" cols="100" rows="10" placeholder="Ex: Pussy | Dog"></textarea>
            <p class="description">Note: This will only censor words that is saved in the database and will not include the hard coded in the theme or plugin files.</p>
          </td>
        </tr>
        <tr>
          <th><label for="">Content to filter:</label></th>
          <td>
            <fieldset>
              <label for="woocommerce_enable_review_rating">
              <input name="woocommerce_enable_review_rating" id="woocommerce_enable_review_rating" type="checkbox" class="" value="1" checked="checked" data-dashlane-rid="2e6faabccab995a6" data-form-type="other"> Title
              </label>
            </fieldset>
            <fieldset>
              <label for="woocommerce_enable_review_rating">
              <input name="woocommerce_enable_review_rating" id="woocommerce_enable_review_rating" type="checkbox" class="" value="1" checked="checked" data-dashlane-rid="2e6faabccab995a6" data-form-type="other"> Content
              </label>
            </fieldset>
            <fieldset>
              <label for="woocommerce_enable_review_rating">
              <input name="woocommerce_enable_review_rating" id="woocommerce_enable_review_rating" type="checkbox" class="" value="1" checked="checked" data-dashlane-rid="2e6faabccab995a6" data-form-type="other"> Comments
              </label>
            </fieldset>
          </td>
        </tr>
        <tr>
          <th><label for="">Post types:</label></th>
          <td>
            <fieldset>
              <label for="woocommerce_enable_review_rating">
              <input name="woocommerce_enable_review_rating" id="woocommerce_enable_review_rating" type="checkbox" class="" value="1" checked="checked" data-dashlane-rid="2e6faabccab995a6" data-form-type="other"> Post
              </label>
            </fieldset>
            <fieldset>
              <label for="woocommerce_enable_review_rating">
              <input name="woocommerce_enable_review_rating" id="woocommerce_enable_review_rating" type="checkbox" class="" value="1" checked="checked" data-dashlane-rid="2e6faabccab995a6" data-form-type="other"> Page
              </label>
            </fieldset>
          </td>
        </tr>
        <tr>
          <th><label for="">Keyword rendering:</label></th>
          <td>
            <fieldset>
              <label><input type="radio" name="word-rendering" checked> Replace all words (ex. Cloudy = ******)</label><br>
              <label><input type="radio" name="word-rendering"> Exclude first letter (ex. Cloudy = C*****)</label><br>
              <label><input type="radio" name="word-rendering"> Exclude first and last letter (ex. Cloudy = C****y)</label><br>
            </fieldset>
          </td>
        </tr>
        <tr>
          <th><label for="">Replace keywords with:</label></th>
          <td>
            <input name="" id="" type="text" value="" class="" placeholder="" style="width: 400px">
            <p class="description">Note: If left blank, will use asterisk (*) as default.</p>
          </td>
        </tr>
        <tr>
          <th><label for="">Apply the changes on the following users:</label></th>
          <td>
            <fieldset>
              <label for="woocommerce_enable_review_rating">
              <input name="woocommerce_enable_review_rating" id="woocommerce_enable_review_rating" type="checkbox" class="" value="1" checked="checked" data-dashlane-rid="2e6faabccab995a6" data-form-type="other"> Logged-in
              </label>
            </fieldset>
            <fieldset>
              <label for="woocommerce_enable_review_rating">
              <input name="woocommerce_enable_review_rating" id="woocommerce_enable_review_rating" type="checkbox" class="" value="1" checked="checked" data-dashlane-rid="2e6faabccab995a6" data-form-type="other"> Visitors
              </label>
            </fieldset>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="submit">
      <button name="save" class="button-primary woocommerce-save-button" type="submit" value="Save changes" data-dashlane-rid="c3528e224c4c85fa" data-dashlane-label="true" data-form-type="action">Save changes</button>
    </p>
  </form>
</div>
