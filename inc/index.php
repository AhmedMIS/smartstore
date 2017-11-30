<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=810">

  <title>Microfiche.js</title>

  <link rel="stylesheet" href="vendor/prettify.css">
  <link rel="stylesheet" href="microfiche.css">
  <link rel="stylesheet" href="microfiche.demo.css">
  <script src="vendor/jquery-1.7.1.js"></script>
  <script src="vendor/prettify.js"></script>
  <script src="microfiche.js"></script>
  <script type="text/javascript" src="http://fast.fonts.com/jsapi/b4bd1e58-b76c-41db-beda-55eac402a457.js"></script>

  <script>
    function example(id) {
      document.write(
        '<div class="example" id="' + id + '">' +
          '<div>' +
            '<ul>' +
              '<li><img src="images/1.jpg" width="160" height="160"></li>' +
              '<li><img src="images/2.jpg" width="160" height="160"></li>' +
              '<li><img src="images/3.jpg" width="160" height="160"></li>' +
              '<li><img src="images/4.jpg" width="160" height="160"></li>' +
              '<li><img src="images/5.jpg" width="160" height="160"></li>' +
              '<li><img src="images/6.jpg" width="160" height="160"></li>' +
              '<li><img src="images/7.jpg" width="160" height="160"></li>' +
              '<li><img src="images/8.jpg" width="160" height="160"></li>' +
              '<li><img src="images/9.jpg" width="160" height="160"></li>' +
              '<li><img src="images/10.jpg" width="160" height="160"></li>' +
              '<li><img src="images/11.jpg" width="160" height="160"></li>' +
              '<li><img src="images/12.jpg" width="160" height="160"></li>' +
              '<li><img src="images/13.jpg" width="160" height="160"></li>' +
              '<li><img src="images/14.jpg" width="160" height="160"></li>' +
            '</ul>' +
          '</div>' +
        '</div>'
      );
    }
  </script>
</head>
<body>
  <div class="body-subcontainer">

    <section id="heading">
    
    </section>
 <h3>Defaults</h3>

    <div class="demo">
      <p><code class="prettyprint">$('#default').microfiche();</code></p>
      <script>example('default')</script>
      <script>$('#default').microfiche()</script>
    </div>
</body>
 </html>
