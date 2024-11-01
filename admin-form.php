<?php
function ssbg_form_list_images(){
  global $ssbg_settings;

  // Create an instructions list table and prepare
  $imagesTable = new Slideshow_Background_List_Table();
  $imagesTable->prepare_items();
  ?>
  <div class="wrap">
    <div id="icon-tools" class="icon32"><br/></div>
    <h2><?php echo 'Slideshow Background Images'; ?></h2>
    <br/>
    <form id="edit_ssb" action='' method="post">
      <input type="hidden" name="action" value="add_ssb" />
      <input id='new' class='button-primary' type='submit' name='submit' value='Add Slideshow Background Image' />
    </form>
      <?php $imagesTable->display() ?>
    <i><b>Note:</b> All changes to table are saved automatically.</i>
    
    <div>
      <h2>Settings</h2>
      
    <form action="" method="post">
      <input type="hidden" name="action" value="settings_ssb" />
      <table class="form-table">
        <tbody>
          <tr>
            <th scope="row">
              <label for="delay">Rotation Timer in Seconds</label>
            </th>
            <td>
              <input name="delay" type="text" id="delay" value="<?php echo $ssbg_settings['delay']; ?>" class="regular-text">
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="enabled">Slideshow Enabled</label>
            </th>
            <td>
              <input name="enabled" type="checkbox" id="enabled" value="enabled" class="regular-text" <?php if($ssbg_settings['enabled']) echo "checked"; ?> >
            </td>
          </tr>
        </tbody>
      </table>
      <p class="submit"><input type="submit" value="Save Settings" class="button-primary" name="Submit"></p>
    </form>
  
    </div>
  </div>
  <?
}

?>
