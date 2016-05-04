vcl 4.0;

backend default {
  .host = "nginx";
  .port = "80";
}

acl invalidators {
    "web";
}

sub vcl_recv {
    if (req.method == "PURGE") {
        if (!client.ip ~ invalidators) {
            return (synth(405, "Not allowed"));
        }
        return (purge);
    }
}

sub vcl_deliver {

  if (obj.hits > 0) {
      set resp.http.X-Cache = "HIT";
  } else {
      set resp.http.X-Cache = "MISS";
  }

  set resp.http.Access-Control-Allow-Origin = "*";
  set resp.http.Access-Control-Allow-Credentials = "true";

  if (req.method == "OPTIONS") {
      set resp.http.Access-Control-Max-Age = "1728000";
      set resp.http.Access-Control-Allow-Methods = "GET, POST, PUT, DELETE, PATCH, OPTIONS";
      set resp.http.Access-Control-Allow-Headers = "Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since";

      set resp.http.Content-Length = "0";
      set resp.http.Content-Type = "text/plain charset=UTF-8";
      set resp.status = 204;
  }
}
