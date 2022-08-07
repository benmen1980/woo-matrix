jQuery(document).ready(function($) {
    console.log('code fired!');
    // We can also pass the url value separately from ajaxurl for front end AJAX implementations
    jQuery('#simply-add-to-cart').click(function(){
        // here need to generate the array according to inputs
        let matrix = document.getElementById('simply-matrix');
        let cells = matrix.querySelectorAll('[data-var]');
        let vars = [];
        /*
        let vars = [{variation_id:150,quantity:3},
            {variation_id:151,quantity:5},
            {variation_id:152,quantity:6}];
        */
        cells.forEach(function(node,index){
            let quantity = node.getElementsByTagName('input')[0].value;
            // need to fetch the names
            let names = '';
            vars[index]= {
                variation_id :  node.dataset.var,
                quantity     :  quantity,
                names        :  names
            };
        });
        let dataString = {
            product_id : 38,
            variations : vars
        };
        var jsonString = JSON.stringify(dataString);
        var data = {
            'action': 'simply_add_to_cart',
            // send the nonce along with the request
            simplyNonce: ajax_object.simplyNonce,
            'whatever' : ajax_object.we_value,      // We pass php values differently!
            'data'     : dataString
        };
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            console.log('Got this from the server: ' + response);
        });
        return false;
    });

});