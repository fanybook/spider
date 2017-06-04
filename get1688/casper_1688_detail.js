phantom.outputEncoding="gbk";

var casper = require('casper').create({
//    verbose: true,
//    logLevel: "debug"
});

var url = casper.cli.get(0);

casper.start(url);

casper.then(function() {
    this.evaluate(function() {
        setTimeout(function() {
            window.scrollTo(0,300);
        }, 500);
        setTimeout(function() {
            window.scrollTo(0,600);
        }, 1000);
        setTimeout(function() {
            window.scrollTo(0,900);
        }, 1500);
    });

    this.wait(2000, function() {
        this.echo(this.page.content);
//        this.echo(this.getHTML());
    });
});

casper.run();