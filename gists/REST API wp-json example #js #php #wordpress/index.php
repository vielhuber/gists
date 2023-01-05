// on blog: install and activate https://de.wordpress.org/plugins/rest-api/

// inside other page:
$blog = @file_get_contents('http://tld.com/wp-json/wp/v2/posts?per_page=1&orderby=date&order=desc&_embed');
if( $blog !== false ) {
 print_r( json_decode($blog) );
}

// js
$(document).ready(function() {
  if( $('.blog').length > 0 ) {
      $.getJSON( "http://tld.com/wp-json/wp/v2/posts?per_page=1&orderby=date&order=desc&_embed", function( data ) {
          if( data.length > 0 ) {
              var news = data[0];
              var html = "";
              html += '<li class="blog">';
                      html += '<h3>';
                          html += '<strong>Blog:</strong> ';
                          html += news['title']['rendered'];
                      html += '</h3>';
                      if( news['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url'] !== undefined ) {
                          html += '<div class="image" style="background-image:url(\''+news['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url']+'\');"></div>';
                      }
                      html += '<div class="content">';
                          if( news['content']['rendered'].indexOf('<!--more-->') > -1 ) {
                              html += news['content']['rendered'].substr( 0, news['content']['rendered'].indexOf('<!--more-->') );
                          }
                          else {
                              html += news['content']['rendered'];
                          }
                      html += '</div>';
                      html += '<div class="more"><a href="'+news['link']+'">weiterlesen</a></div>';
                      html += '<div class="b">';
                         var d = new Date(news.date);
                          html += '<span class="date">'+(('0'+d.getDate()).slice(-2)+'.'+('0'+(d.getMonth()+1)).slice(-2)+'.'+d.getFullYear())+'</span>';
                  html += '</div>';
              html += '</li>';
              $('.blog').append(html);
          }
      });
  }
});