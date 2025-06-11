<?php

class domainCategory
{
  var $current_version = '1.0.0';
  var $translation_domain = 'wiki-domain-classfication';
  var $groupName;
  var $action;

  //  load_plugin_textdomain($this->translation_domain, false, dirname(__FILE__) . '/languages/'); 


  function domainCategory()
  {
    global $wpdb;
  }


  function dntitle()
  {
    global $id;
    $blog_id = get_current_lang();
    $this->action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

    if (isset($_REQUEST['dnid']) || $_REQUEST['dnid'] <> '') {
      $id = $_REQUEST['dnid'];
      // $this->groupName =  $_REQUEST['groupid'] . '.'. $id; 
      $this->groupName = $_REQUEST['groupid'];

    } else {
      $id = '28';

      $this->groupName = $id;
    }
    // if ($title=='总根' || $title=='ALL'){
    $title = $this->get_jointitle_by_uniqid($id);
    if ($this->is_domain_leaf($this->groupName))
      $title = $title . '(' . $this->domain_member_number($this->groupName) . ')';

    //  }

    return $title;
  }



  function makecontent()
  {
    global $post;
    global $current_user;
    global $wpdb, $id;
    $usertable = 'yzwp_users';
    $posttable = $wpdb->prefix . '_posts';
    // $posttable = 'Domain_Classification'; 
    $jointable = 'domainName';
    $dnTreetable = 'domainTree';
    $dnNametable = 'DNName';

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';


    $blog_id = get_current_lang();
    if (isset($_REQUEST['dnid']) || $_REQUEST['dnid'] <> '') {
      $id = $_REQUEST['dnid'];
      // $this->groupName =  $_REQUEST['groupid'] . '.'. $id; 
      $this->groupName = $_REQUEST['groupid'];

    } else {
      $id = '28';
      $this->groupName = $id;
    }

    $new_content = '';
    if ($action != 'edit') {

      $top = "";
      $btop = "";
      $btop .= '<div class="incsub_wiki incsub_wiki_single">';
      if (get_locale() == 'zh_CN') {
        $dwikipage = SITEURL . '/cdswiki/index.php/' . $this->get_title_by_id($id);
        $postviewpage = SITEURL . '/' . $this->groupName . '/postview.html';

      } else {
        $dwikipage = SITEURL . '/dswiki/index.php/' . $this->get_title_by_id($id);
        $postviewpage = SITEURL . '/' . $this->groupName . '/postview.html';

      }
      $btop .= '<a href="' . $dwikipage . '" target="_blank">' . __('Domain Wiki Page', $this->translation_domain) . '</a>';

      $btop .= '</br><a href="' . $postviewpage . '" target="_blank">' . __('Domain Posts View', $this->translation_domain) . '</a>';


      $btop .= '<div class="incsub_wiki_tabs incsub_wiki_tabs_top">' . $this->tabs($id) . '<div class="incsub_wiki_clear"></div></div>';

      switch ($action) {

        case 'editpost':
          if (is_user_logged_in()) {
            if (current_user_can('administrator')) {
              $content = $_REQUEST['content'];
              $post_title = $_REQUEST['post_title'];
              $post_ID = $_REQUEST['post_ID'];
              $parent_id = $_REQUEST['parent_id'];
              $child_id = isset($_REQUEST['child_id']) ? $_REQUEST['child_id'] : '-1';
              //   $this->groupName =  $_REQUEST['groupid'];
              //   echo $this->groupName ;
              $edit_type = $_REQUEST['edittype'];


              if ($edit_type == 'insert') {

                $id1 = $this->pre_add_dnname($this->groupName, $post_title, $content);
                if ($id1 <> -1) {
                  $id = $id1;
                  $this->groupName = $this->get_parent_groupdnid($this->groupName) . '.' . $id;

                }

              }

              if ($edit_type == 'insertmeta') {
                //  $id1 =  $this->pre_add_dnname($this->groupName, $post_title, $content);
                if ($id1 <> -1) {
                  $id = $id1;
                  $this->groupName = $this->get_parent_groupdnid($this->groupName) . '.' . $id;

                }

              }

              if ($edit_type == 'insertmany') {
                //  $id1 =  $this->pre_add_dnname($this->groupName, $post_title, $content);
                $tdnames = explode(' ', $content);
                foreach ($tdnames as $titlename) {
                  $id1 = $this->pre_add_dnname($this->groupName, $titlename, "");
                }

                if ($id1 <> -1) {
                  $id = $id1;
                  $this->groupName = $this->get_parent_groupdnid($this->groupName) . '.' . $id;

                }

              }


              // crate new domains from sub domain trees
              if ($edit_type == 'creatmeta') {
                $tdnames = explode(' ', $content);
                foreach ($tdnames as $titlename) {
                  $id1 = $this->add_dnname($this->groupName, $titlename, "");
                }
                if ($id1 <> -1) {
                  $id = $id1;
                  $this->groupName .= '.' . $id;
                }
              }


            }







            if ($edit_type == 'create') {
              $id1 = $this->add_dnname($this->groupName, $post_title, $content);
              //     echo  $id1 ;
              //      echo"<script type='text/javascript'>alert( $id1 );</script>";


              if ($id1 <> -1) {
                $id = $id1;
                $this->groupName .= '.' . $id;
              }
            }

            // domains divided by blank
            if ($edit_type == 'createmany') {
              $tdnames = explode(' ', $content);
              foreach ($tdnames as $titlename) {
                $id1 = $this->add_dnname($this->groupName, $titlename, "");
              }
              if ($id1 <> -1) {
                $id = $id1;
                $this->groupName .= '.' . $id;
              }
            }


            if ($edit_type == 'edit') {

              $this->update_dnname($post_ID, $post_title, $content);

            }


            $redirect = SITEURL . '/dc/domainview.php?dnid=' . $id . '&groupid=' . $this->groupName;
            ;

            $_REQUEST['action'] = 'view';
          }
          break;

        case 'remove':
          if (is_user_logged_in()) {
            if (current_user_can('administrator')) {
              $blog_id = get_current_lang();
              $parentID = $this->get_parent_id($this->groupName);
              $this->remove_domainTree($id, $this->groupName);

              $redirect = SITEURL . '/dc/domainview.php?dnid=' . $parentID . '&groupid=' . $this->get_parent_groupdnid($this->groupName);


              // echo '<script type="text/javascript">'.
              // 'window.location = "'.$redirect.'";'.
              //  '</script>';
            }
          }
          break;


        /*
                         case 'check':
                             if ( is_user_logged_in() ) {
                                     if (current_user_can('administrator')){  
                               $blog_id = get_current_lang();
                             // $parentID = $this->get_parent_id($id);
                              $this->check_domainTree();  
                             //  $redirect = get_permalink().'?dnid='.$parentID ;
                              // echo '<script type="text/javascript">'.
                          // 'window.location = "'.$redirect.'";'.
                      //  '</script>';
                                }
                              }
                               break;
        */


        case 'join_group':
          if (is_user_logged_in()) {

            $blog_id = get_current_lang();
            get_currentuserinfo();
            $username1 = $current_user->user_login;

            $insertsql = 'INSERT INTO ' . $jointable . '  (username, domainID) Values("' . $username1 . '",   "' . $this->groupName . '")';
            $wpdb->query($insertsql);
            $redirect = SITEURL . '/dc/domainview.php?dnid=' . $id . '&groupid=' . $this->groupName;

            //   echo '<script type="text/javascript">'.
            //  'window.location = "'.$redirect.'";'.
            //   '</script>';

          }
          break;

        case 'leave_group':
          if (is_user_logged_in()) {

            $blog_id = get_current_lang();

            $username1 = $current_user->user_login;
            $deletesql = 'DELETE FROM ' . $jointable . ' where  domainID =  "' . $this->groupName . '"   and  username = "' . $username1 . '"';
            $wpdb->query($deletesql);

            $redirect = SITEURL . '/dc/domainview.php?dnid=' . $id . '&groupid=' . $this->groupName;


            // echo '<script type="text/javascript">'.
            // 'window.location = "'.$redirect.'";'.
            //  '</script>';

          }
          break;



        case 'edit':
          set_include_path(get_include_path() . PATH_SEPARATOR . ABSPATH . 'wp-admin');

          //    $post_type_object = get_post_type_object($post->post_type);

          //    $p = $post; 
          $title = $this->dntitle($title);
          //   $post = $this->post_to_edit($id);

          $new_content = '';
          break;

        default:

          $crumbs = array();
          $ancestors = $this->get_ancester_by_groupid($this->groupName);
          //        echo $this->groupName;
          //      $ancestors = array_reverse( $ancestors,true);

          foreach ($ancestors as $parent_pid) {
            if ($parent_pid === '')
              break;
            $post_title = $this->get_jointitle_by_uniqid($parent_pid);
            $crumbs[] = '<a href="' . SITEURL . '/dc/domainview.php?dnid=' . $parent_pid . '&groupid=' . $this->get_id_groupname($this->groupName, $parent_pid) . '">' . $post_title . '</a>';

          }

          $crumbs[] = '<span class="incsub_wiki_crumbs">' . $this->get_jointitle_by_uniqid($id)
            . '</span>';

          //  sort($crumbs);

          $top .= join(get_option("incsub_meta _seperator", " > "), $crumbs);

          //   $children = $this->get_children_by_id( $id);
          $children = $this->get_children_by_groupid($this->groupName);
          // echo 'here';

          $crumbs = array();
          foreach ($children as $child) {
            //$crumbs[] = '<div><a href="' . SITEURL . '/' . $child . '/' . $this->groupName . '.' . $child . '/domainview.html">' . $this->get_jointitle_by_uniqid($child) . '</a></div>';
            $crumbs[] = '<a href="' . SITEURL . '/dc/domainview.php?dnid=' . $child . '&groupid=' . $this->groupName . '">' . $post_title . '</a>';

          }

          $bottom = "<h3>" . __('Sub Domains', $this->translation_domain) . "</h3> <ul><li>";

          $bottom .= join("</li><li>", $crumbs);

          if (count($crumbs) == 0) {
            $bottom = "";
          } else {
            $bottom .= "</li></ul>";
          }

          $new_content = $btop . '<div>' . $top . '</div>' . $new_content;

          $new_content .= '<div>' . $this->get_content_by_id($id) . '</div>';

          $new_content .= '<div>' . $bottom . '</div>';


          $redirect = false;
      }

      $new_content .= '</div>';
    }

    /*
         $new_content .= '<style type="text/css">'.
     '#comments { display: none; }'.
     '</style>';
     */


    // Empty post_type means either malformed object found, or no valid parent was found.


    if (!empty($redirect)) {
      echo '<script type="text/javascript">' .
        'window.location = "' . $redirect . '";' .
        '</script>';
      exit;
    }

    return $new_content;
  }


  function get_the_DNname($id)
  {
    global $wpdb;
    $blog_id = get_current_lang();

    $dnTreetable = 'domainTree';
    $sqlstr2 = 'Select domainN From ' . $dnTreetable . ' where id= ' . $id . 'AND blog_id = ' . $blog_id;
    return $wpdb->get_var($sqlstr2);
  }

  function get_the_DNDescription($id)
  {
    global $wpdb;
    $blog_id = get_current_lang();

    $dnTreetable = 'domainTree';
    $sqlstr2 = 'Select description From ' . $dnTreetable . ' where id= ' . $id . 'AND blog_id = ' . $blog_id;
    return $wpdb->get_var($sqlstr2);

  }




  function get_edit_form()
  {
    global $post, $wp_version;
    global $id;
    $blog_id = get_current_lang();

    if (isset($_REQUEST['dnid']) || $_REQUEST['dnid'] === '') {
      $id = $_REQUEST['dnid'];
      //    $this->groupName =  $_REQUEST['groupid'] . '.'. $id; 
      $this->groupName = $_REQUEST['groupid'];

    } else {
      //  $id =   ($blog_id  ===1)?'221':'28';
      $id = '28';
      $this->groupName = $id;
    }


    echo '<div class="incsub_wiki incsub_wiki_single">';

    echo '<h3>' . __('Edit', $this->translation_domain) . '</h3>';
    echo '<form action="' . SITEURL . '/dc/domainview.php?dnid=' . $id . '&groupid=' . $this->groupName . '" method="post">';

    if (isset($_REQUEST['eaction']) && $_REQUEST['eaction'] == 'insert') {
      echo '<input type="hidden" name="edittype" id="edittype_action" value="insert" />';


      echo '<input type="hidden" name="groupid" id="groupid" value="' . $this->groupName . '" />';

      // echo '<input  type="text"  name="groupid" id="groupid" value="'.$this->groupName .'" />';

      echo '<div><input type="text" name="post_title" id="wiki_title" value=" " class="incsub_wiki_title" size="30" /></div>';

      echo '<textarea tabindex="2" name="content" id="wiki_content" class="incusb_wiki_tinymce" cols="70" rows="30" ></textarea>';

    } else if (isset($_REQUEST['eaction']) && $_REQUEST['eaction'] == 'insertmeta') {
      echo '<input type="hidden" name="edittype" id="edittype_action" value="insertmeta" />';


      echo '<input type="hidden" name="groupid" id="groupid" value="' . $this->groupName . '" />';

      echo ' meta groupd ID:<div><input type="text" name="metagropdid" id="metagropdid" value=" " class="incsub_wiki_title" size="30" /></div>';
      echo ' meta length <div><input type="text" name="metalength" id="metalength" value=" " class="incsub_wiki_title" size="3" /></div>';

    } else if (isset($_REQUEST['eaction']) && $_REQUEST['eaction'] == 'insertmany') {
      echo '<input type="hidden" name="edittype" id="edittype_action" value="insertmany" />';



      echo '<input type="hidden" name="groupid" id="groupid" value="' . $this->groupName . '" />';
      echo '<textarea tabindex="2" name="content" id="wiki_content" class="incusb_wiki_tinymce" cols="70" rows="30" ></textarea>';




    } else if (isset($_REQUEST['eaction']) && $_REQUEST['eaction'] == 'createmany') {
      echo '<input type="hidden" name="edittype" id="edittype_action" value="createmany" />';

      echo '<input  type="hidden"  name="groupid" id="groupid" value="' . $this->groupName . '" />';

      echo '<textarea tabindex="2" name="content" id="wiki_content" class="incusb_wiki_tinymce" cols="70" rows="30" ></textarea>';

    } else if (isset($_REQUEST['eaction']) && $_REQUEST['eaction'] == 'createmeta') {
      echo '<input type="hidden" name="edittype" id="edittype_action" value="createmeta" />';

      echo '<input  type="hidden"  name="groupid" id="groupid" value="' . $this->groupName . '" />';
      echo ' meta groupdID:<div><input type="text" name="metagropdid" id="metagropdid" value=" " class="incsub_wiki_title" size="30" /></div>';
      echo 'meta length:<div><input type="text" name="metalength" id="metalength" value=" " class="incsub_wiki_title" size="3" /></div>';






    } else if (isset($_REQUEST['eaction']) && $_REQUEST['eaction'] == 'create') {
      //	    echo '<input type="hidden" name="parent_id" id="parent_id" value="'.$this->groupName.'" />';
      //   echo '<input type="hidden" name="post_ID" id="wiki_id" value="0" />';
      echo '<input type="hidden" name="edittype" id="edittype_action" value="create" />';

      // echo '<input type="hidden" name="groupid" id="groupid" value="'.$this->groupName .'" />';

      echo '<input  type="hidden"  name="groupid" id="groupid" value="' . $this->groupName . '" />';

      echo '<div><input type="text" name="post_title" id="wiki_title" value=" " class="incsub_wiki_title" size="30" /></div>';

      echo '<textarea tabindex="2" name="content" id="wiki_content" class="incusb_wiki_tinymce" cols="70" rows="30" ></textarea>';




    } else {
      //  $parentgrID = $this->get_parent_groupdnid($this->groupName);
      //  echo '<input type="hidden" name="parent_id" id="parent_id" value="'.$parentgrID .'" />';
      echo '<input type="hidden" name="post_ID" id="wiki_id" value="' . $id . '" />';
      echo '<input type="hidden" name="edittype" id="edittype_action" value="edit" />';

      echo '<input type="hidden" name="groupid" id="groupid" value="' . $this->groupName . '" />';

      // echo '<input  type="text"  name="groupid" id="groupid" value="'.$this->groupName .'" />';


      echo '<div><input type="text" name="post_title" id="wiki_title" value="' . $this->get_title_by_id($id) . '" class="incsub_wiki_title" size="30" /></div>';

      echo '<textarea tabindex="2" name="content" id="wiki_content" class="incusb_wiki_tinymce" cols="70" rows="30" >' . $this->get_content_by_id($id) . '</textarea>';



    }





    echo '<input type="hidden" name="action" id="wiki_action" value="editpost" />';

    echo '<input type="hidden" name="_wpnonce" id="_wpnonce" value="' . wp_create_nonce("wiki-editpost_{$edit_post->id}") . '" />';

    echo '<div class="incsub_wiki_clear">';
    echo '<input type="submit" name="save" id="btn_save" value="' . __('Save', $this->translation_domain) . '" />&nbsp;';
    echo '<a href="' . SITEURL . '/dc/domainview.php?dnid=' . $id . '&groupid=' . $this->groupName . '">' . __('Cancel', $this->translation_domain) . '</a>';

    echo '</div>';
    echo '</form>';
    echo '</div>';


    return '';
  }

  function tabs($id)
  {
    global $post, $incsub_tab_check;
    global $current_user;
    global $wpdb;
    $usertable = 'yzwp_users';
    $posttable = $wpdb->prefix . '_posts';
    // $posttable = 'Domain_Classification'; 
    $jointable = 'domainName';
    $dnTreetable = 'domainTree';
    $dnNametable = 'DNName';



    $incsub_tab_check = 1;

    $classes['page'] = array('incsub_wiki_link_page');
    $classes['discussion'] = array('incsub_wiki_link_discussion');
    $classes['history'] = array('incsub_wiki_link_history');
    $classes['edit'] = array('incsub_wiki_link_edit');
    $classes['advanced_edit'] = array('incsub_wiki_link_advanced_edit');
    $classes['join_group'] = array('incsub_wiki_link_join_group');
    $classes['leave_group'] = array('incsub_wiki_link_leave_group');
    $classes['remove'] = array('incsub_wiki_link_remove');
    $classes['check'] = array('incsub_wiki_link_check');

    $classes['insert'] = array('incsub_wiki_link_insert');





    $classes['create'] = array('incsub_wiki_link_create');

    if (!isset($_REQUEST['action'])) {
      $classes['page'][] = 'current';
    }
    if (isset($_REQUEST['action'])) {
      switch ($_REQUEST['action']) {
        case 'page':
          $classes['page'][] = 'current';
          break;
        case 'discussion':
          $classes['discussion'][] = 'current';
          break;
        case 'restore':
        case 'diff':
        case 'history':
          $classes['history'][] = 'current';
          break;


        case 'join_group':
          $classes['join_group'][] = 'current';
          break;

        case 'leave_group':
          $classes['leave_group'][] = 'current';


          break;


        case 'edit':
          if (isset($_REQUEST['eaction']) && $_REQUEST['eaction'] == 'create') {
            $classes['create'][] = 'current';
          } else
            $classes['edit'][] = 'current';
          break;
        case 'remove':
          $classes['remove'][] = 'current';


          break;
        case 'check':
          $classes['check'][] = 'current';

          break;


      }
    }

    $seperator = (preg_match('/\?/i', get_permalink()) > 0) ? '&' : '?';

    $tabs = '<div><ul class="left">';
    if ($this->check_user_cap($id, 'create')) {

      //if (is_user_logged_in()) {
//           	    $tabs .= '<li class="'.join(' ', $classes['create']).'"><a href="'.get_permalink().$seperator.'action=edit&eaction=create&dnid='.$id.'&groupid='.$this->groupName.'">'.__('Create new', $this->translation_domain).'</a></li>';

      $tabs .= '<li class="' . join(' ', $classes['create']) . '"><a href="' . SITEURL . '/dc/domainview.php?action=edit&eaction=create&dnid=‘  . $id . '&groupid='   . $this->groupName . '">' . __('Create new', $this->translation_domain) . '</a></li>';





    }

    if ($this->check_user_cap($id, 'create')) {

      if (current_user_can('publish_pages')) {
        //           	    $tabs .= '<li class="'.join(' ', $classes['create']).'"><a href="'.get_permalink().$seperator.'action=edit&eaction=createmany&dnid='.$id.'&groupid='.$this->groupName.'">'.__('Create Many', $this->translation_domain).'</a></li>';

        $tabs .= '<li class="' . join(' ', $classes['create']) . '"><a href="' . SITEURL . '/dc/domainmanage.php?action=edit&eaction=createmany&dnid=‘   . $id .   '&groupid='   . $this->groupName . '">' . __('Create Many', $this->translation_domain) . '</a></li>';


      }
    }


    if ($this->check_user_cap($id, 'create')) {

      if (is_super_admin()) {
        // 	    $tabs .= '<li class="'.join(' ', $classes['create']).'"><a href="'.get_permalink().$seperator.'action=edit&eaction=createmeta&dnid='.$id.'&groupid='.$this->groupName.'">'.__('Create Meata', $this->translation_domain).'</a></li>';
        $tabs .= '<li class="' . join(' ', $classes['create']) . '"><a href="' . SITEURL . '/dc/domainmanage.php?action=edit&eaction=createmeta&dnid=‘   . $id .   '&groupid='   . $this->groupName . '">' . __('Create Meata', $this->translation_domain) . '</a></li>';



      }

    }

    if ($this->check_user_cap($id, 'insert')) {
      if (is_super_admin()) {
        if ($this->groupName <> '28') {

          //           	    $tabs .= '<li class="'.join(' ', $classes['create']).'"><a href="'.get_permalink().$seperator.'action=edit&eaction=insert&dnid='.$id.'&groupid='.$this->groupName.'">'.__('Insert new', $this->translation_domain).'</a></li>';

          $tabs .= '<li class="' . join(' ', $classes['create']) . '"><a href="' . SITEURL . '/' . $id . '/' . $this->groupName . '/domaineins.html">' . __('Insert new', $this->translation_domain) . '</a></li>';


        }
      }
    }


    if ($this->check_user_cap($id, 'insert')) {
      if (is_super_admin()) {
        if ($this->groupName <> '28') {

          //    $tabs .= '<li class="'.join(' ', $classes['create']).'"><a href="'.get_permalink().$seperator.'action=edit&eaction=insertmeta&dnid='.$id.'&groupid='.$this->groupName.'">'.__('Insert Meta', $this->translation_domain).'</a></li>';

          $tabs .= '<li class="' . join(' ', $classes['create']) . '"><a href="' . SITEURL . '/' . $id . '/' . $this->groupName . '/domaineinsmeta.html">' . __('Insert Meta', $this->translation_domain) . '</a></li>';

        }
      }
    }

    if ($this->check_user_cap($id, 'insert')) {
      if (is_super_admin()) {
        if ($this->groupName <> '28') {

          //           	    $tabs .= '<li class="'.join(' ', $classes['create']).'"><a href="'.get_permalink().$seperator.'action=edit&eaction=insertmany&dnid='.$id.'&groupid='.$this->groupName.'">'.__('Insert Many', $this->translation_domain).'</a></li>';

          $tabs .= '<li class="' . join(' ', $classes['create']) . '"><a href="' . SITEURL . '/' . $id . '/' . $this->groupName . '/domaineinsm.html">' . __('Insert Many', $this->translation_domain) . '</a></li>';


        }
      }
    }





    if (is_user_logged_in()) {

      $current_user = wp_get_current_user();
      $blog_id = get_current_lang();



      //    $sqlstr1 =  'Select count(*) From  ' . $dnTreetable .  '  where   parent_id  =  '. $id     ;

      //    $countnum1 = $wpdb->get_var( $sqlstr1 );

      //echo $usernames ;
      //  if (  $countnum1  ==0)
      if ($this->is_domain_leaf($this->groupName)) {
        $sqlstr2 = 'Select count(*) From  ' . $jointable . '  where  domainID  =  "' . $this->groupName . '"   and  username = "' . $current_user->user_login . '"';

        $countnum = $wpdb->get_var($sqlstr2);


        if ($countnum == 0)
          //             $tabs .= '<li class="'.join(' ', $classes['join_group']).'" ><a href="'.get_permalink().$seperator.'action=join_group&dnid='.$id.'&groupid='.$this->groupName.'" >' . __('no joined, want Join?', $this->translation_domain) . '</a></li>';
          $tabs .= '<li class="' . join(' ', $classes['join_group']) . '" ><a href="' . SITEURL . '/dc/domainview.php?action=join_group&dnid='   . $id .   '&groupid='   . $this->groupName . '" >' . __('no joined, want Join?', $this->translation_domain) . '</a></li>';
        else
          //          $tabs .= '<li class="'.join(' ', $classes['leave_group']).'" ><a href="'.get_permalink().$seperator.'action=leave_group&dnid='.$id.'&groupid='.$this->groupName.'" >' . __('has Joined, want Leave?', $this->translation_domain) . '</a></li>';

          $tabs .= '<li class="' . join(' ', $classes['leave_group']) . '" ><a href="' . SITEURL . '/dc/domainview.php?action=leave_group&dnid='   . $id .  '&groupid='   . $this->groupName . '" >' . __('has Joined, want Leave?', $this->translation_domain) . '</a></li>';


      }

    }

    // $tabs .= '</ul></div>';


    $post_type_object = get_post_type_object($post->post_type);
    if ($this->check_user_cap($id, 'edit')) {

      //if (current_user_can('edit_post', $post->ID)) {
      //      $post_title = get_post($post->ID);
      //     if ( ($post_title->post_author == $current_user->ID) || (current_user_can('edit_other_posts'))) {

      // 	    $tabs .= '<li class="'.join(' ', $classes['edit']).'" ><a href="'.get_permalink().$seperator.'action=edit&eaction=edit&dnid='.$id.'&groupid='.$this->groupName.'" >' . __('Edit', $this->translation_domain) . '</a></li>';

      $tabs .= '<li class="' . join(' ', $classes['edit']) . '" ><a href="' . SITEURL . '/dc/domainview.php?action=edit&dnid='   . $id .   '&groupid='   . $this->groupName . '" >' . __('Edit', $this->translation_domain) . '</a></li>';




      //	}
    }

    if ($this->check_user_cap($id, 'remove')) {

      //if (is_super_admin()) {
      if ($this->groupName <> '28') {


        // $tabs .= '<li class="'.join(' ', $classes['remove']).'"><a href="'.get_permalink().$seperator.'action=remove&dnid='.$id.'&groupid='.$this->groupName.'">'.__('Remove', $this->translation_domain).'</a></li>';


        $tabs .= '<li class="' . join(' ', $classes['remove']) . '"><a href="' . SITEURL . '/dc/domainmanage.php?action=remove&dnid='  . $id .  '&groupid='   . $this->groupName . '">' . __('Remove', $this->translation_domain) . '</a></li>';


        $tabs .= '</ul></div>';
      }
    }

    /*
        if ($this->check_user_cap($id,  'check')) {
      
      if (is_super_admin()) {
                
    //  $tabs .= '<li class="'.join(' ', $classes['check']).'"><a href="'.get_permalink().$seperator.'action=check&dnid='.$id.'">'.__('Check', $this->translation_domain).'</a></li>';

     $tabs .= '<li class="'.join(' ', $classes['check']).'"><a href="'.SITEURL.'/'.$id.'/domaincheck.html">'.__('Check', $this->translation_domain).'</a></li>';


          $tabs .= '</ul></div>';
     }
     }
    */

    $incsub_tab_check = 0;

    return $tabs;
  }






  function check_samename_domainTree_1($domainName)
  {
    global $wpdb;
    if (trim($domainName) == '')
      return true;
    $dnTreetable = 'domainTree';
    $sqlstr2 = 'Select domainN From ' . $dnTreetable . ' where domainN  = "' . $domainName . '"';
    $domainN = $wpdb->get_col($sqlstr2);
    if ($domainN)
      return true;
    else
      return false;


  }


  function check_samename_domainTree($post_id)
  {
    global $wpdb;

    $domainName = trim($_POST['post_title']);
    $dnTreetable = 'domainTree';

    $sqlstr2 = 'Select domainN From ' . $dnTreetable . ' where domainN  = "' . $domainName . '"';
    $domainN = $wpdb->get_col($sqlstr2);
    if ($domainN)
      return true;
    else
      return false;


  }




  function check_modify_title_domainTree($post_id, $domainName)
  {
    global $wpdb;
    $blog_id = get_current_lang();

    $dnTreetable = 'domainTree';
    $sqlstr2 = 'Select domainN From ' . $dnTreetable . ' where id = ' . $post_id . ' AND blog_id = ' . $blog_id;
    $domainN = $wpdb->get_var($sqlstr2);
    if ($domainN != $domainName)
      return true;
    else
      return false;


  }

  function delete_unused_domainIDs($domainID, $tablen, $id, $post_id, $domain)
  {
    global $wpdb;

    $domainManager = 'domainManager';
    $domainName = 'domainName';
    $domainTreeChildID = 'domainTreeChildID';
    $domainPostID = 'domain_postIds';

    if ($tablen === $domainManager) {

      $sqlstr2 = 'SELECT username   FROM ' . $tablen . '  where  domainID   =  "' . $domainID . '"';
      //     echo   $sqlstr2  ;

      $usernames = $wpdb->get_col($sqlstr2);
      foreach ($usernames as $username) {
        //     echo   $username;
        $sqlstr2 = 'DELETE FROM ' . $tablen . '  where  domainID   = "' . $domain . '"  and  username  = "' . $username . '"';
        //        echo   $sqlstr2  ;

        $suc = $wpdb->query($sqlstr2);
        //     echo "after";
      }
    }

    if ($tablen === $domainName) {
      $sqlstr2 = 'DELETE FROM ' . $tablen . '  where  domainID   = "' . $domain . '"  and  username  in (select a.username from(select c.username from ' . $tablen . ' c where  c.domainID   = "' . $domainID . '")a)';
      //      echo   $sqlstr2  ;

      $suc = $wpdb->query($sqlstr2);
    }

    if ($tablen === $domainTreeChildID) {
      $sqlstr2 = 'DELETE FROM ' . $tablen . '  where  domainID   = "' . $domain . '"  and  child_id   in (select a.child_id from(select c.child_id from ' . $tablen . ' c where  c.domainID   = "' . $domainID . '")a)';
      //    echo   $sqlstr2  ;


      $suc = $wpdb->query($sqlstr2);
    }

    if ($tablen === $domainPostID) {
      $sqlstr2 = 'DELETE FROM ' . $tablen . '  where  groupid = "' . $domain . '" ';
      //    echo   $sqlstr2  ;


      $suc = $wpdb->query($sqlstr2);
    }




  }


  function modify_domainIDs($domainID, $tablen, $id, $post_id, $domain)
  {
    global $wpdb;
    $domainPostID = 'domain_postIds';
    if ($tablen === $domainPostID)
      $sqlstr2 = 'UPDATE ' . $tablen . ' SET groupid = "' . $domainID . '"  where groupid = "' . $domain . '"';
    else
      $sqlstr2 = 'UPDATE ' . $tablen . ' SET domainID   = "' . $domainID . '"  where domainID   = "' . $domain . '"';
    //        echo $sqlstr2;
    $suc = $wpdb->query($sqlstr2);

    $this->delete_unused_domainIDs($domainID, $tablen, $id, $post_id, $domain);

  }


  function update_domainIDs($cols, $tablen, $id, $post_id)
  {


    foreach ($cols as $domain) {
      $idarry = explode(".", $domain);
      $flag = false;
      $arnum = count($idarry);
      // echo ' $arnum =' .$arnum;
      for ($i = 0; $i <= $arnum; $i++) {
        if ($idarry[$i] === $id) {
          $idarry[$i] = $post_id;
          $flag = true;
        }
      }

      if ($flag) {
        $domainID = implode(".", $idarry);
        //  echo $domainID ;
        $this->modify_domainIDs($domainID, $tablen, $id, $post_id, $domain);



      }

    }
  }

  function conc_dnname($id, $post_id)
  {
    global $wpdb;
    $blog_id = get_current_lang();

    $dnTreetable = 'domainTree';
    $domainIDManager = 'domainIDManager';
    $domainManager = 'domainManager';
    $domainName = 'domainName';
    $domainTreeChildID = 'domainTreeChildID';
    $domainPostID = 'domain_postIds';

    $sqlstr2 = 'Select domainID   From ' . $domainManager;
    // echo   $sqlstr2;
    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->update_domainIDs($domainIDs, $domainManager, $id, $post_id);


    $sqlstr2 = 'Select domainID   From ' . $domainName;
    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->update_domainIDs($domainIDs, $domainName, $id, $post_id);

    $sqlstr2 = 'UPDATE ' . $domainTreeChildID . ' SET child_id   = ' . $post_id . ' where child_id  = ' . $id;
    $suc = $wpdb->query($sqlstr2);
    // echo $sqlstr2 ;




    $sqlstr2 = 'Select domainID   From ' . $domainTreeChildID;
    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->update_domainIDs($domainIDs, $domainTreeChildID, $id, $post_id);


    $sqlstr2 = 'DELETE FROM ' . $domainTreeChildID . '  where  child_id      =  ' . $id . '  and ' . $post_id . '  in (select a.child_id from(select c.child_id from ' . $domainTreeChildID . ' c )a)';

    // echo  $sqlstr2 ;
    $suc = $wpdb->query($sqlstr2);




    $sqlstr2 = 'UPDATE ' . $domainIDManager . ' SET id = ' . $post_id . ' where id = ' . $id;
    $suc = $wpdb->query($sqlstr2);

    $sqlstr2 = 'DELETE FROM ' . $domainIDManager . ' where id = ' . $id . ' and username  in (select a.username from (select c.username from ' . $domainIDManager . ' c where   c.id = ' . $post_id . ')a)';

    // echo  $sqlstr2 ;
    $suc = $wpdb->query($sqlstr2);


    $sqlstr2 = 'UPDATE ' . $dnTreetable . ' SET id = ' . $post_id . ' where id = ' . $id . ' AND blog_id = ' . $blog_id;
    $suc = $wpdb->query($sqlstr2);


    $sqlstr2 = 'Select groupid From ' . $domainPostID;
    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->update_domainIDs($domainIDs, $domainPostID, $id, $post_id);






  }



  function check_dnname($post_id, $domainName)
  {
    if (trim($domainName) === '')
      return -2;
    if (strpos($domainName, '.'))
      return -2;
    global $wpdb;
    $blog_id = get_current_lang();
    $dnTreetable = 'domainTree';
    $sqlstr2 = 'Select id From ' . $dnTreetable . ' where domainN = "' . $domainName . '" AND blog_id = ' . $blog_id;
    $id = $wpdb->get_var($sqlstr2);
    // echo $sqlstr2  .  $id  ;
    // echo 'id='. $id  ;

    if ($id != $post_id) {
      if (!$id) {
        $sqlstr2 = 'Select count(*) From ' . $dnTreetable . ' where id = ' . $post_id . ' AND blog_id = ' . $blog_id;
        $numid = $wpdb->get_var($sqlstr2);
        if ($numid > 0)
          return -3;
        else
          return -1;


      }
      $sqlstr2 = 'Select count(*) From ' . $dnTreetable . ' where id = ' . $id;
      $idnum = $wpdb->get_var($sqlstr2);
      //    echo $idnum  ;
      if ($idnum > 1)
        return -2;
      $this->conc_dnname($id, $post_id);
      return 0;
    } else
      return 0;
  }





  function update_dnname($post_id, $domainName, $dcontent)
  {
    //  echo "update dnname"; 
    $domainName = trim($domainName);
    $check = $this->check_dnname($post_id, $domainName);

    if ($check === -2) {
      $erromsg = "do not use blank or contains . character name !";
      echo "<script type='text/javascript'>alert($erromsg);</script>";

      return false;
    }
    global $wpdb;
    $blog_id = get_current_lang();
    $dnTreetable = 'domainTree';
    //  $dnNametable  = 'DNName' ; 
    if ($check === -1)
      $sqlstr2 = 'INSERT INTO ' . $dnTreetable . ' (domainN , description, id , blog_id )  VALUES ("' . $domainName . '",   "' . $dcontent . '"  , ' . $post_id . ' , ' . $blog_id . ')';
    else
      $sqlstr2 = 'UPDATE ' . $dnTreetable . ' SET domainN = "' . $domainName . '",  description = "' . $dcontent . '"  where id = ' . $post_id . ' AND blog_id = ' . $blog_id;
    // echo $sqlstr2  ;
    $suc = $wpdb->query($sqlstr2);
    // echo"<script type='text/javascript'>alert($post_id );</script>";

    if ($suc)
      return true;
    else
      return false;

  }







  function check_user_cap($post_id, $checktype)
  {
    global $wpdb;
    global $current_user;
    $dnmanagertable = 'domainManager';
    $dnTreetable = 'domainTree';
    $domainNametable = 'domainName';

    if (!(is_user_logged_in()))
      return false;


    $blog_id = get_current_lang();

    get_currentuserinfo();
    $username = $current_user->user_login;
    if ($username == 'admin')
      return true;
    if (!($this->is_domain_leaf($this->groupName))) {
      if ($checktype == 'create')
        return true;
    }
    if (!($this->get_title_by_id($post_id))) {
      if ($checktype == 'edit')
        return true;
    }


    $sql = 'select count(id) from  ' . $dnmanagertable . '  where  username = "' . $username . '"  AND id = ' . $post_id . ' AND blog_id = ' . $blog_id . ' AND m_type = "c"';
    $num = $wpdb->get_var($sql);
    if ($num == 0) {
      if ($checktype != 'create')
        return false;
    }
    if ($this->is_domain_leaf($this->groupName)) {
      $sql = 'SELECT  count(username)  FROM ' . $domainNametable . ' where id  = ' . $post_id . ' AND blog_id = ' . $blog_id . ' AND username <> "' . $username . '"';
      $count = $wpdb->get_var($sql);
      if ($count > 0) {
        //             if ($checktype != 'create')

        return false;
      }
    }



    //        $child_ids   = $this->get_children_by_id($post_id);
    $child_ids = $this->get_children_by_groupid($this->groupName);


    foreach ($child_ids as $child_id) {
      $sql = 'select username from  ' . $dnmanagertable . '  where   id = ' . $child_id . ' AND blog_id = ' . $blog_id . ' AND m_type = "c"';
      $username1 = $wpdb->get_var($sql);
      if ($username != $username1)
        return false;
      if ($this->is_domain_leaf($this->groupName)) {
        $sql = 'SELECT  count(username)  FROM ' . $domainNametable . ' where id  = ' . $child_id . ' AND blog_id = ' . $blog_id . '  AND username <> "' . $username . '"';
        $count = $wpdb->get_var($sql);
        if ($count > 0)
          return false;
      }


    }

    return true;


  }







  function get_children_by_groupid($groupid)
  {
    global $wpdb;
    $blog_id = get_current_lang();

    $childtable = 'domainTreeChildID';


    $sqlstr1 = 'Select child_id  from  ' . $childtable . '   where  domainID = "' . $groupid . '"';


    return $wpdb->get_col($sqlstr1);

  }

  function get_domainname_by_id($id)
  {
    global $wpdb;
    $blog_id = get_current_lang();

    $posttable = 'domainTree';


    $sqlstr1 = 'Select domainN from  ' . $posttable . '   where  blog_id = ' . $blog_id . ' and id   = ' . $id;

    return $wpdb->get_var($sqlstr1);

  }






  function get_ancester_by_groupid($groupname)
  {
    $ids = explode(".", $groupname);
    $id = end($ids);

    $parentgroupname = $this->get_parent_groupname($groupname, $id);
    //     echo   $id . '/p';
    //echo    $parentgroupname. '/p';

    return explode(".", $parentgroupname);
  }



  function get_content_by_id($post_id)
  {
    global $wpdb;
    $blog_id = get_current_lang();

    $posttable = 'domainTree';

    $sqlstr1 = 'Select description  from  ' . $posttable . ' where blog_id = ' . $blog_id . ' and id = ' . $post_id;
    //   echo $sqlstr1  ;
    return $wpdb->get_var($sqlstr1);

  }

  function get_title_by_id($post_id)
  {
    global $wpdb;
    $blog_id = get_current_lang();

    $posttable = 'domainTree';

    $sqlstr1 = 'Select domainN from  ' . $posttable . ' where blog_id = ' . $blog_id . ' and id = ' . $post_id;
    return $wpdb->get_var($sqlstr1);

  }

  function get_title_by_uniqid_en($post_id)
  {
    global $wpdb;
    $blog_id = get_current_lang();

    $posttable = 'domainTree';

    $sqlstr1 = 'Select domainN from  ' . $posttable . ' where blog_id = 30   and id = ' . $post_id;
    return $wpdb->get_var($sqlstr1);

  }



  function get_title_by_uniqid_cn($post_id)
  {
    global $wpdb;
    $blog_id = get_current_lang();

    $posttable = 'domainTree';

    $sqlstr1 = 'Select domainN from  ' . $posttable . ' where blog_id = 1   and id = ' . $post_id;
    return $wpdb->get_var($sqlstr1);

  }





  function get_jointitle_by_uniqid($post_id)
  {
    $blog_id = get_current_lang();
    $rnd = rand(0, 10);

    if ($blog_id === 1)
      return $this->get_title_by_uniqid_cn($post_id) . ' ' . $this->get_title_by_uniqid_en($post_id);
    else if ($blog_id === 30)
      return $this->get_title_by_uniqid_en($post_id) . ' ' . $this->get_title_by_uniqid_cn($post_id);
    else
      return $this->get_title_by_uniqid($post_id) . ' ' . $this->get_title_by_uniqid_en($post_id) . ' ' . $this->get_title_by_uniqid_cn($post_id);


  }







  function get_unique_post_id()
  {
    global $wpdb;
    $posttable = 'domainTree';
    $sqlstr1 = 'Select MAX(id) from  ' . $posttable;
    return $wpdb->get_var($sqlstr1) + 1;

  }



  function get_parent_groupname($groupid, $id)
  {
    $pos = strpos($groupid, $id);
    if ($pos > 0)
      return substr($groupid, 0, strpos($groupid, $id) - 1);
    else
      return '';
  }

  function get_id_groupname($groupid, $id)
  {
    $pos = strpos($groupid, $id);
    $idsize = strlen($id);
    if ($pos > 0)
      return substr($groupid, 0, strpos($groupid, $id) + $idsize);
    elseif ($pos === 0) {
      $blog_id = get_current_lang();
      return '28';
    } else
      return false;
  }




  function get_parent_id($groupid)
  {
    $groupname = $this->get_parent_groupdnid($groupid);
    $ids = explode(".", $groupname);
    return end($ids);
  }

  function get_id_from_groupid($groupid)
  {
    $ids = explode(".", $groupid);
    return end($ids);
  }



  function get_parent_groupdnid($groupid)
  {
    $ids = explode(".", $groupid);
    $id = end($ids);

    return $groupname = $this->get_parent_groupname($groupid, $id);
  }





  function up_domainName($post_id)
  {
    global $wpdb;

    $posttable = $wpdb->prefix . 'posts';
    $dnTreetable = 'domainTree';
    $domainNametable = 'domainName';
    $blog_id = get_current_lang();
    $parent_id = get_parent_id($post_id);
    $updatesql = 'UPDATE ' . $domainNametable . '  SET  id  = ' . $parent_id . ' where id  = ' . $post_id . ' AND blog_id = ' . $blog_id;
    $wpdb->query($updatesql);



  }





  function copy_dnname($post_id)
  {
    global $wpdb;

    $domainNametable = 'domainName';
    $blog_id = get_current_lang();

    $parent_id = $this->get_parent_id($post_id);

    $updatesql = 'UPDATE ' . $domainNametable . '  SET  id  = ' . $post_id . ' where id  = ' . $parent_id . ' AND blog_id = ' . $blog_id;

    $wpdb->query($updatesql);




  }





  function insert_between_domainTree($post_id, $child_id)
  {
    global $wpdb;

    $dnTreetable = 'domainTree';
    $blog_id = get_current_lang();

    $parent_id = $post_id;



    $updatesql = 'UPDATE ' . $dnTreetable . '  SET  parent_id  = ' . $parent_id . ' where id  = ' . $child_id . ' AND blog_id = ' . $blog_id;
    $wpdb->query($updatesql);

  }


  function check_domainTree()
  {
    //  $this->check_join_domainTree() ;
    //  $this->check_child_domainTree(); 
    //    $this->check_manager_domainTree(); 

  }

  function check_join_domainTree()
  {
    global $wpdb;
    $dnTreetable = 'domainTree';
    $blog_id = get_current_lang();
    $domainNametable = 'domainName';
    $sqlq = 'select  id   from ' . $domainNametable . ' where blog_id = ' . $blog_id;
    $dnarray = $wpdb->get_col($sqlq);
    //   echo  $sqlq ;
    foreach ($dnarray as $dnid) {
      //  echo  $dnid;

      $anster = $dnid;
      $domanpath = $anster;
      do {

        $newanster = $this->get_parent_id($anster);

        if ($newanster) {
          $domanpath = $newanster . '.' . $domanpath;
          $anster = $newanster;
        } else {
          break;
        }
      } while (1);

      //   echo $domanpath ;
      $updatesql = 'UPDATE ' . $domainNametable . '  SET  domanpath   = "' . $domanpath . '" where id  = ' . $dnid . ' AND blog_id = ' . $blog_id;
      $wpdb->query($updatesql);
    }




  }


  function check_child_domainTree()
  {
    global $wpdb;
    $dnTreetable = 'domainTree';
    $blog_id = get_current_lang();
    $domainchildNametable = 'domainTreeChildID';
    $sqlq = 'select  id   from ' . $domainchildNametable . ' where blog_id = ' . $blog_id;
    $dnarray = $wpdb->get_col($sqlq);
    //   echo  $sqlq ;
    foreach ($dnarray as $dnid) {
      //  echo  $dnid;

      $anster = $dnid;
      $domanpath = $anster;
      do {

        $newanster = $this->get_parent_id($anster);

        if ($newanster) {
          $domanpath = $newanster . '.' . $domanpath;
          $anster = $newanster;
        } else {
          break;
        }
      } while (1);

      //   echo $domanpath ;
      $updatesql = 'UPDATE ' . $domainchildNametable . '  SET  domainID = "' . $domanpath . '" where id  = ' . $dnid . ' AND blog_id = ' . $blog_id;
      $wpdb->query($updatesql);
    }




  }




  function check_manager_domainTree()
  {
    global $wpdb;
    $domainIDmanagertable = 'domainIDManager';
    $blog_id = get_current_lang();
    $domainmanagertable = 'domainManager';
    $sqlq = 'select username, id , blog_id , m_type  from ' . $domainIDmanagertable . ' where blog_id = ' . $blog_id;
    $dnarray = $wpdb->get_results($sqlq);
    foreach ($dnarray as $dnid) {
      //  echo  $dnid;

      $anster = $dnid->id;
      $domanpath = $anster;
      do {

        $newanster = $this->get_parent_id($anster);

        if ($newanster) {
          $domanpath = $newanster . '.' . $domanpath;

          $anster = $newanster;
        } else {
          break;
        }
      } while (1);
      $ids = explode(".", $domanpath);
      $dndomanpath = '';
      if ($ids[0] == 221 || $ids[0] == 28) {
        foreach ($ids as $id) {
          if ($dndomanpath === '')
            $dndomanpath = $id;
          else
            $dndomanpath = $dndomanpath . '.' . $id;

          $sqlstr1 = 'Select count(*) From  ' . $domainmanagertable . '  where   domainID  =  "' . $dndomanpath . '"';

          $countnum1 = $wpdb->get_var($sqlstr1);
          // echo   $countnum1 ;

          if ($countnum1 == 0) {
            //         echo   'hi' ;


            $sql = 'INSERT INTO ' . $domainmanagertable . ' (username,  blog_id, m_type , domainID)  VALUES("' . $dnid->username . '",   ' . $dnid->blog_id . ', "' . $dnid->m_type . '",  "' . $dndomanpath . '" )';
            //       echo   $sql ;
            $wpdb->query($sql);
          }
        }
      }

    }




  }


  function remove_modify_domainIDs($domainID, $tablen, $groupid, $post_id, $domain)
  {
    global $wpdb;
    $domainPostID = 'domain_postIds';

    if ($tablen === $domainPostID)
      $sqlstr2 = 'UPDATE ' . $tablen . ' SET groupid = "' . $domainID . '"  where groupid = "' . $domain . '"';
    else

      $sqlstr2 = 'UPDATE ' . $tablen . ' SET domainID   = "' . $domainID . '"  where domainID   = "' . $domain . '"';
    //             echo $sqlstr2;
    $suc = $wpdb->query($sqlstr2);

    $this->delete_unused_domainIDs($domainID, $tablen, $groupid, $post_id, $domain);

  }


  function remove_update_domainIDs($cols, $tablen, $groupid, $post_id)
  {

    $idarry0 = $this->get_parent_groupdnid($groupid);

    foreach ($cols as $domain) {
      // echo '$tablen$domain ='.$tablen. $domain.'/p';
// echo '$groupid = '.  $groupid.'/p';



      if (!(strpos($domain, $groupid) === FALSE)) {
        if (strpos($domain, $groupid) === 0) {

          //    $idarry0 = $this->get_parent_groupdnid($groupid);
          // echo $idarry0 . '/p';
          $idarry1 = substr($domain, strlen($groupid), strlen($domain) - strlen($groupid));
          //  echo $idarry1 . '/p';

          $domainID = $idarry0 . $idarry1;
          // echo $domainID . '/p';

          $this->modify_domainIDs($domainID, $tablen, $groupid, $post_id, $domain);

          // echo"<script type='text/javascript'>alert($domainID);</script>";
        }
      }

    }
  }


  function remove_domainTree($post_id, $groupid)
  {
    global $wpdb;
    $domainManager = 'domainManager';
    $domainName = 'domainName';
    $domainTreeChildID = 'domainTreeChildID';
    $domainPostID = 'domain_postIds';
    //    $blog_id = get_current_lang();                 

    if ($this->has_member_id($groupid))
      return;

    $sqlstr2 = 'Select domainID   From ' . $domainManager;

    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->remove_update_domainIDs($domainIDs, $domainManager, $groupid, $post_id);


    $sqlstr2 = 'Select domainID   From ' . $domainName;
    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->remove_update_domainIDs($domainIDs, $domainName, $groupid, $post_id);



    $idarry0 = $this->get_parent_groupdnid($groupid);

    $deletesql = 'DELETE FROM ' . $domainTreeChildID . ' where  domainID =  "' . $idarry0 . '"   and  child_id= ' . $post_id;
    $suc = $wpdb->query($deletesql);

    // echo  $deletesql ;

    $sqlstr2 = 'Select domainID   From ' . $domainTreeChildID;

    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->remove_update_domainIDs($domainIDs, $domainTreeChildID, $groupid, $post_id);

    $sqlstr2 = 'Select groupid   From ' . $domainPostID;

    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->remove_update_domainIDs($domainIDs, $domainPostID, $groupid, $post_id);



    // echo"<script type='text/javascript'>alert($post_id );</script>";





  }



  function has_member_id($groupid)
  {
    global $wpdb;
    $domainNametable = 'domainName';
    $sqlstr1 = 'Select count(*) From  ' . $domainNametable . '  where   domainID =  "' . $groupid . '"  ';
    $count = $wpdb->get_var($sqlstr1);
    if ($count > 0)
      return true;
    else
      return false;

  }


  function domain_member_number($groupid)
  {
    global $wpdb;
    $domainNametable = 'domainName';
    $blog_id = get_current_lang();
    $sqlstr1 = 'Select count(*) From  ' . $domainNametable . '  where   domainID =  "' . $groupid . '"  ';

    return $wpdb->get_var($sqlstr1);
  }


  function is_domain_leaf($groupid)
  {
    global $wpdb;
    $childtable = 'domainTreeChildID';
    $blog_id = get_current_lang();

    $sqlstr1 = 'Select count(*) From  ' . $childtable . '  where   domainID =  "' . $groupid . '" ';
    //      echo $sqlstr1 ;
    $countnum1 = $wpdb->get_var($sqlstr1);
    // echo $countnum1 ;

    if ($countnum1 > 0)
      return false;
    else
      return true;
  }




  function pre_insert_update_Child_domainIDs($cols, $tablen, $groupid, $post_id)
  {

    global $wpdb;
    // echo $groupid .'/p';
// echo $post_id.'/p';
// if ( $this->is_domain_leaf( $groupid )) 
// {

    $insertsql = 'INSERT INTO domainTreeChildID( domainID,child_id ) Values("' . $this->get_parent_groupdnid($groupid) . '", ' . $post_id . '   )';
    $wpdb->query($insertsql);
    // echo  $insertsql ;

    $insertsql = 'INSERT INTO domainTreeChildID( domainID,child_id ) Values("' . $this->get_parent_groupdnid($groupid) . '.' . $post_id . '", ' . $this->get_id_from_groupid($groupid) . '   )';
    $wpdb->query($insertsql);
    // echo  $insertsql ;

    $idarry0 = $this->get_parent_groupdnid($groupid);

    $deletesql = 'DELETE FROM  domainTreeChildID   where  domainID =  "' . $idarry0 . '"   and  child_id= ' . $this->get_id_from_groupid($groupid);
    $suc = $wpdb->query($deletesql);
    // echo $deletesql ;


    //   return true;
//}



    foreach ($cols as $domain) {
      // echo  $tablen.$domain.'/p';
      if (!(strpos($domain, $groupid) === FALSE)) {
        if (strpos($domain, $groupid) === 0) {

          $idarry0 = $this->get_parent_groupdnid($groupid);
          // echo 'idary'.$idarry0 . '/p';
          $idarry1 = substr($domain, strlen($idarry0), strlen($domain) - strlen($idarry0));
          // echo 'idary1'.$idarry1 . '/p';

          $domainID = $idarry0 . '.' . $post_id . $idarry1;
          // echo $domainID . '/p';

          $this->modify_domainIDs($domainID, $tablen, $groupid, $post_id, $domain);

          // echo"<script type='text/javascript'>alert($domainID);</script>";
        }
      }

    }
  }





  function pre_insert_update_domainIDs($cols, $tablen, $groupid, $post_id)
  {

    global $wpdb;
    // echo $groupid .'/p';
// echo $post_id.'/p';

    foreach ($cols as $domain) {
      // echo  $tablen.$domain.'/p';
      if (!(strpos($domain, $groupid) === FALSE)) {
        if (strpos($domain, $groupid) === 0) {

          $idarry0 = $this->get_parent_groupdnid($groupid);
          //   echo 'idary'.$idarry0 . '/p';
          $idarry1 = substr($domain, strlen($idarry0), strlen($domain) - strlen($idarry0));
          //   echo 'idary1'.$idarry1 . '/p';

          $domainID = $idarry0 . '.' . $post_id . $idarry1;
          //   echo $domainID . '/p';

          $this->modify_domainIDs($domainID, $tablen, $groupid, $post_id, $domain);

          //  echo"<script type='text/javascript'>alert($domainID);</script>";
        }
      }

    }
  }



  function pre_insert_domainTree($domainid, $groupName, $post_title, $dcontent)
  {

    global $wpdb;
    global $current_user;

    $dnTreetable = 'domainTree';

    $domainManager = 'domainManager';
    $domainName = 'domainName';
    $domainTreeChildID = 'domainTreeChildID';
    $domainPostID = 'domain_postIds';

    $blog_id = get_current_lang();



    $insertsql = 'INSERT INTO ' . $dnTreetable . '  (domainN, id,description , blog_id ) Values("' . $post_title . '", ' . $domainid . ' ,    "' . $dcontent . '" , ' . $blog_id . ')';
    $wpdb->query($insertsql);

    get_currentuserinfo();
    $username1 = $current_user->user_login;

    $insertsql = 'INSERT INTO  domainIDManager  (username, id,  m_type ) Values("' . $username1 . '", ' . $domainid . ' ,    "c"   )';
    $wpdb->query($insertsql);

    $sqlstr2 = 'Select domainID   From ' . $domainManager;

    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->pre_insert_update_domainIDs($domainIDs, $domainManager, $groupName, $domainid);


    $sqlstr2 = 'Select domainID   From ' . $domainName;
    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->pre_insert_update_domainIDs($domainIDs, $domainName, $groupName, $domainid);

    $sqlstr2 = 'Select domainID   From ' . $domainTreeChildID;
    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->pre_insert_update_Child_domainIDs($domainIDs, $domainTreeChildID, $groupName, $domainid);

    $sqlstr2 = 'Select groupid From ' . $domainPostID;
    $domainIDs = $wpdb->get_col($sqlstr2);
    $this->pre_insert_update_domainIDs($domainIDs, $domainPostID, $groupName, $domainid);




    // echo  $insertsql ;



    //   echo"<script type='text/javascript'>alert($domainid);</script>";






  }







  function pre_add_dnname($groupName, $post_title, $content)
  {
    $post_title = trim($post_title);
    $domainid = $this->find_id_domainTree($post_title);
    //      echo $domainid ;
    if ($domainid === -1)
      return -1;
    else if ($domainid === -2) {
      $domainid = $this->get_unique_post_id();

    } else {

      $content = $this->get_content_by_id($domainid);
    }
    $this->pre_insert_domainTree($domainid, $groupName, $post_title, $content);

    return $domainid;
  }





  function insert_domainTree($domainid, $groupName, $post_title, $dcontent)
  {

    global $wpdb;
    global $current_user;

    $dnmanagertable = 'domainManager';

    $dnTreetable = 'domainTree';

    $blog_id = get_current_lang();

    $insertsql = 'INSERT INTO ' . $dnTreetable . '  (domainN, id,description , blog_id ) Values("' . $post_title . '", ' . $domainid . ' ,    "' . $dcontent . '" , ' . $blog_id . ')';
    $wpdb->query($insertsql);

    get_currentuserinfo();
    $username1 = $current_user->user_login;

    $insertsql = 'INSERT INTO  domainIDManager  (username, id,  m_type ) Values("' . $username1 . '", ' . $domainid . ' ,    "c"   )';
    $wpdb->query($insertsql);
    $newgoupid = $groupName . '.' . $domainid;
    $insertsql = 'INSERT INTO ' . $dnmanagertable . '  (username, domainID , m_type ) Values("' . $username1 . '" , " ' . $newgoupid . '"  ,    "c"   )';
    $wpdb->query($insertsql);

    $insertsql = 'INSERT INTO domainTreeChildID( domainID,child_id ) Values("' . $groupName . '", ' . $domainid . '   )';
    $wpdb->query($insertsql);
    // echo  $insertsql ;






  }







  function find_id_domainTree($domainName)
  {
    global $wpdb;
    if (trim($domainName) == '')
      return -1;
    $dnTreetable = 'domainTree';
    $blog_id = get_current_lang();

    $sqlstr2 = 'Select id From ' . $dnTreetable . ' where domainN  = "' . $domainName . '" AND blog_id = ' . $blog_id;

    $domainid = $wpdb->get_var($sqlstr2);
    if ($domainid)
      return $domainid;
    else
      return -2;


  }




  function add_dnname($groupName, $post_title, $content)
  {
    $post_title = trim($post_title);
    /*
      if ($this->check_samename_domainTree($post_id))     
           return -1;
   */
    $domainid = $this->find_id_domainTree($post_title);
    //       echo $domainid ;
    if ($domainid === -1)
      return -1;
    else if ($domainid === -2) {
      $domainid = $this->get_unique_post_id();

    } else {

      $content = $this->get_content_by_id($domainid);
    }
    $this->insert_domainTree($domainid, $groupName, $post_title, $content);

    return $domainid;
  }


}



?>