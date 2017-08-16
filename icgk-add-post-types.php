<?php
/*
Plugin Name: ICGK Add Post Types
Plugin URI: 
Description: カスタムポストタイプを作成
Version: 1.0.0
Author: ICHIGENKI
Author URI: 
License: GPL2
*/

// 登録するカスタムポストタイプの設定
$post_types = array(
	array(
		'name' => '',
		'label' => '',
		'slug' => '',
		'hierarchical' => true, // 固定ページ型：true、投稿型：false
		'position' => 5,
		// 5:投稿の下、10:メディアの下、15:リンクの下、20:固定ページの下、25:コメントの下、60:外観の下、65:プラグインの下、70:ユーザーの下、75:ツールの下、80:設定の下、100:最下部に独立させる
		//'tax' => '',
		'tax' => array(
			't_name' => '',
			't_label' => '',
			't_slug' => '',
			't_hierarchical' => true, // カテゴリー型：true、タグ型：false
		),
	),
);

function icgk_add_custom_post_type() {
	foreach( $post_types as $ptype ) :
		if( $ptype['name'] ) :
			$name = $ptype['name'];
			$label = $ptype['label'];
			$slug = $ptype['slug'];
			$hier = $ptype['hier'];
			$pos = $ptype['pos'];
			if( $slug == '' ) $slug = $name;

			// カスタムポストタイプの登録
			register_post_type(
				$name, 
				array(
					'labels' => array(
						'name' => __( $label ),
						'singular_name' => __( $label )
					),
					'public' => true,
					'rewrite' => array('slug' => $slug),
					'hierarchical' => $hier,
					'menu_position' => $pos,
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
					'exclude_from_search' => true,
				)
			);

			if( $ptype['tax'] ) :
				$taxonomies = $ptype['tax'];
				foreach( $taxonomies as $tax ) :
					$t_name = $tax['t_name'];
					$t_label = $tax['t_label'];
					$t_slug = $tax['t_slug'];
					$t_hier = $tax['t_hierarchical'];
					if( $t_slug == '' ) $t_slug = $t_name;

					// カスタムタクソノミーの登録
					register_taxonomy(
						$t_name,
						$name,
						array(
							'label' => __( $t_label ),
							'rewrite' => array( 'slug' => $t_slug ),
							'hierarchical' => $t_hier,
						)
					);
				endforeach;
			endif;

		endif;
	endforeach;
	flush_rewrite_rules();
}