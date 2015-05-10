<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <style type="text/css">
      * {
        box-sizing: border-box;
      }
      body {
        background: #ddd;
        font-family: Helvetica, Arial, sans-serif;
        margin: 0;
        padding: 0;
      }
        .container {
          background: #fff;
          overflow: hidden;
          padding: 15px 30px;
          border: 1px solid #aaa;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
          margin: 30px;
        }
          a {
            color: #337ab7;
            text-decoration: none;
          }
          a:active,
          a:focus,
          a:hover {
            color: #23527c;
            text-decoration: underline;
          }
          .footer {
            margin: 30px 0 0;
            font-size: 0.8em;
            color: #888;
          }
    </style>
  </head>
  <body>
    <div class="container">
      <p>Hi {{ $name }},</p>

      @yield('content')

      <br />
      <p>Kind regards,<br /><br />The UKRDA Email Robot</p>
      <div class="footer">
        <p>This message was sent to you automatically on behalf of the <a href="http://ukrda.org.uk/">United Kingdom Roller Derby Association</a> by <a href="http://muster.ukrda.org.uk/">Muster</a>.</p>
      </div>
    </div>
  </body>
</html>
