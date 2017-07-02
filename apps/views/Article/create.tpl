<h1>Article create<br /></h1>
<form action="<!----value:document_root---->Article/save/" method="post">
  <input type="hidden" name="Article[user_id]" length="64" value="<!----value:Article:user_id---->"><br>
  <div >
    <div>
      article_category_id
    </div>
    <div>
      <select name="Article[article_category_id]">
        <!----select_options:Article:article_category_id:ArticleCategory:name---->
      </select>
    </div>
  </div>
  <div>
    <div>
      file_name
    </div>
    <div>
      <input type="text" name="Article[file_name]" length="128" value="<!----value:Article:file_name---->"><br>
    </div>
  </div>
  <div>
    <div>
      title
    </div>
    <div>
      <input type="text" name="Article[title]" length="128" value="<!----value:Article:title---->"><br>
    </div>
  </div>
  <div>
    <div>
      body
    </div>
    <div>
      <input type="text" name="Article[body]" length="5000" value="<!----value:Article:body---->"><br>
    </div>
  </div>
  <input type="submit" name="bottom">
</form>
