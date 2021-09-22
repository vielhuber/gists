<?php
class CustomSearch
{
	public static function output()
	{
		echo self::generate();
	}

	public static function shortcode()
	{
		add_shortcode('custom_search', function() {
			return self::generate();
		});
	}

	public static function generate()
	{
		$results = self::fetch();
		echo '<pre>';print_r($results);echo '</pre>';
		// do whatever you want to do
		$output = '';
		return $output;
	}

	public static function fetch()
	{
		$results = [];
		if( isset($_GET['q']) && $_GET['q'] != '' ) {
			$query = strip_tags($_GET['q']);
			$results = self::fetch_terms($results, $query);
			$results = self::fetch_posts($results, $query);
		}
		$results = array_slice($results, 0, 10);
		return $results;
	}

	public static function fetch_terms($results, $query)
	{
		global $wpdb;
		$result_db = $wpdb->get_results($wpdb->prepare(
			"
			SELECT term_id FROM dh_terms WHERE
				EXISTS( SELECT * FROM dh_term_taxonomy WHERE dh_term_taxonomy.term_id = dh_terms.term_id AND dh_term_taxonomy.taxonomy IN ('manufacturer_category','product_category','news_category') )
				AND
				EXISTS( SELECT * FROM dh_term_relationships WHERE dh_term_relationships.object_id = dh_terms.term_id AND dh_term_relationships.term_taxonomy_id IN ( SELECT dh_term_taxonomy.term_taxonomy_id FROM dh_term_taxonomy WHERE dh_term_taxonomy.taxonomy = 'term_translations' AND dh_term_taxonomy.description LIKE CONCAT('%%s:2:\"".pll_current_language()."\";i:',dh_terms.term_id,';%%') ) )
				AND
				(
					(
						name LIKE %s
					)
					OR
					(
						term_id IN (SELECT term_id FROM dh_termmeta WHERE meta_value LIKE %s)
					)
				)
			ORDER BY name ASC
			LIMIT 10
			",
			['%'.$query.'%','%'.$query.'%']
		));
		if(!empty($result_db))
		{
			foreach($result_db as $result_db__value)
			{
				$term = get_term($result_db__value->term_id);
				if( get_field('disabled', $term->taxonomy.'_'.$term->term_id) == '1' ) { continue; }
				$term_meta = get_option('wpseo_taxonomy_meta');
				$term_content = null;
				if( isset($term_meta[$term->taxonomy]) && isset($term_meta[$term->taxonomy][$term->term_id]) && isset($term_meta[$term->taxonomy][$term->term_id]['wpseo_desc']) )
				{
					$term_content = $term_meta[$term->taxonomy][$term->term_id]['wpseo_desc'];
				}
				$results[] = [
					'image' => get_field('logo', $term->taxonomy.'_'.$term->term_id),
					'border' => true,
					'title' => $term->name,
					'content' => $term_content,
					'url' => get_term_link($term->term_id)
				];
			}
		}
		return $results;
	}

	public static function fetch_posts($results, $query)
	{
		global $wpdb;
		$result_db = $wpdb->get_results($wpdb->prepare(
			"
			SELECT post_title, ID FROM dh_posts WHERE
				post_status = 'publish'
				AND
				post_type IN ('post','page')
				AND
				EXISTS( SELECT * FROM dh_term_relationships WHERE dh_term_relationships.object_id = dh_posts.ID AND dh_term_relationships.term_taxonomy_id IN ( SELECT dh_term_taxonomy.term_taxonomy_id FROM dh_term_taxonomy WHERE dh_term_taxonomy.taxonomy = 'language' AND dh_term_taxonomy.description LIKE '%%s:5:\"".pll_current_language()."%%' ) )
				AND
				(
					(
						post_title LIKE %s
					)
					OR
					(
						post_content LIKE %s
					)
					OR
					(
						ID IN (SELECT post_id FROM dh_postmeta WHERE meta_value LIKE %s)
					)
				)
			ORDER BY ID DESC
			LIMIT 10
			",
			['%'.$query.'%','%'.$query.'%','%'.$query.'%']
		));
		if(!empty($result_db))
		{
			foreach($result_db as $result_db__value)
			{
				$results[] = [
					'image' => get_field('excerpt_image',$result_db__value->ID),
					'border' => false,
					'title' => get_the_title($result_db__value->ID),
					'content' => get_post_meta($result_db__value->ID, '_yoast_wpseo_metadesc', true),
					'url' => get_permalink($result_db__value->ID)
				];
			}
		}
		return $results;
	}

}