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
