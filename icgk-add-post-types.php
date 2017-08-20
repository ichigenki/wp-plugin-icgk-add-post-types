<?php
/*
Plugin Name: ICGK Add Post Types
Plugin URI: 
Description: カスタムポストタイプをプラグイン編集により作成
Version: 1.0.0
Author: ICHIGENKI
Author URI: 
License: GPL2
*/

function icgk_add_custom_post_type() {

  // 登録するカスタムポストタイプの設定
  $post_types = array(
    array(
      'name' => 'contentpage',
      'label' => 'コンテンツページ',
      'slug' => 'content',
      'hierarchical' => true, // 固定ページ型：true、投稿型：false
      'position' => 5,
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'custom-fields',
        //'excerpt',
        'author',
        'page-attributes',
        //'trackbacks',
        //'comments',
        //'revisions'
      ),
      'search' => false, // 検索対象にしない：true、する：false
      'tax' => '',
    ),
    array(
      'name' => 'news',
      'label' => 'お知らせ',
      'slug' => 'topic',
      'hierarchical' => false, // 固定ページ型：true、投稿型：false
      'position' => 5,
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'custom-fields',
        //'excerpt',
        'author',
        'page-attributes',
        //'trackbacks',
        //'comments',
        //'revisions',
      ),
      'search' => false, // 検索対象にしない：true、する：false
      //'tax' => '',
      'tax' => array(
        't_name' => 'newscat',
        't_label' => 'お知らせ分類',
        't_slug' => 'tclass',
        't_hierarchical' => true, // カテゴリー型：true、タグ型：false
      )
    ),

  /* カスタムポストタイプ登録用のデフォルト形

    array(
      'name' => '',
      'label' => '',
      'slug' => '',
      'hierarchical' => true, // 固定ページ型：true、投稿型：false
      'position' => 5, // メニュー表示位置
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'custom-fields',
        //'excerpt',
        'author',
        'page-attributes',
        //'trackbacks',
        //'comments',
        //'revisions'
      ),
      'search' => false, // 検索対象にしない：true、する：false
      //'tax' => '',
      'tax' => array(
        't_name' => '',
        't_label' => '',
        't_slug' => '',
        't_hierarchical' => true, // カテゴリー型：true、タグ型：false
      )
    ),

  // メニュー表示位置は下の通り（デフォルトはコメントの下）
  // 5:投稿の下、10:メディアの下、15:リンクの下、20:固定ページの下、25:コメントの下、60:外観の下、65:プラグインの下、70:ユーザーの下、75:ツールの下、80:設定の下、100:最下部に独立させる
  */
  );

  if( $post_types ) :
    foreach( $post_types as $ptype ) :
      $name = $ptype['name'];
      $label = $ptype['label'];
      $slug = $ptype['slug'];
      if( $slug == '' ) $slug = $name;
      $hier = $ptype['hierarchical'];
      $pos = $ptype['position'];
      $sup = $ptype['supports'];
      $srch = $ptype['search'];
      $tax = $ptype['tax'];

      // カスタムポストタイプの登録
      $args = array(
        'labels' => array(
          'name' => __( $label ),
          'singular_name' => __( $label )
        ),
        'public' => true,
        'rewrite' => array('slug' => $slug),
        'hierarchical' => $hier,
        'menu_position' => $pos,
        'supports' => $sup,
        'exclude_from_search' => $srch,
      );
      register_post_type($name, $args);

      if( $tax ) :
        $t_name = $tax['t_name'];
        $t_label = $tax['t_label'];
        $t_slug = $tax['t_slug'];
        if( $t_slug == '' ) $t_slug = $t_name;
        $t_hier = $tax['t_hierarchical'];

        // カスタムタクソノミーの登録
        $t_args = array(
          'label' => __( $t_label ),
          'rewrite' => array('slug' => $t_slug),
          'hierarchical' => $t_hier,
        );
        register_taxonomy($t_name, $name, $t_args);
      endif;

    endforeach;
  endif;
  flush_rewrite_rules();
}
add_action( 'init', 'icgk_add_custom_post_type' );
