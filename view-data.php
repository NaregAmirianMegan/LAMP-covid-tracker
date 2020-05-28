<?php 
    require "header.php";
?>
<html>
    <head>
        <style type="text/css">
            #container {
                max-width: 700px;
                height: 400px;
                margin: auto;
                border: 1px solid #B22222;
                border-radius: 10px;
            }
        </style>
    </head>
    <body>
         <form action="gen-json.php" method="post">
            <button type="submit" name="refresh">Refresh</button>
        </form>
        <div id="container"></div>
        <script src="sigma.js/build/sigma.min.js"></script>
        <script src="sigma.js/build/plugins/sigma.parsers.json.min.js"></script>
        <script src="sigma.js/plugins/sigma.layout.noverlap/sigma.layout.noverlap.js"></script>
        <script src="sigma.js/plugins/sigma.plugins.animate/sigma.plugins.animate.js"></script>
        <script>
            var s = new sigma({
                                renderer: {
                                    container: document.getElementById('container'),
                                    type: 'canvas'
                                },
                                settings: {
                                    defaultNodeColor: '#ec5148',
                                    minArrowSize: 10
                                }
                            });
            sigma.parsers.json('./data.json', s,
                    function() {
                        s.refresh();
                    }
                );

            var config = {
                nodeMargin: 20.0,  
                scaleNodes: 2
            };
            // Configure the algorithm
            var listener = s.configNoverlap(config);

            // Bind all events:
            listener.bind('start stop interpolate', function(event) {
                console.log(event.type);
            });

            // Start the algorithm:
            s.startNoverlap();
        </script>
    </body>
</html>