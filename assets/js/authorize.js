/**
* MooTools script for authorising with Flickr
*
* @version  1.2
* @author Daniel Eliasson - joomla at stilero.com
* @copyright  (C) 2012-maj-20 Stilero Webdesign http://www.stilero.com
* @category MooToolsScript
* @license    GPLv2
*/
window.addEvent('domready', function(){
    var api_key = $(apiKeyElement).value;
    var api_secret = $(apiSecretElement).value;
    var frob = $(frobElement).value;
    var authElmnt = $(authorizeElement).get('html');
    var loader = '<span class="ajaxloader-blue"></span>';
    
    /**
     * Sets the Button href link.
     * @param Object response response object
     * @returns void
     */    
    var setButtonHref = function(response){
        //var link = getUrl();
        if(response !== undefined){
            $(authorizeElement).href = response.url;
        }
        if($(authTokenElement).value === ''){
            $(authorizeElement).innerHTML = 'Connect to Flickr';
            $(authorizeElement).set('class', 'fbconnect  btn btn-success');
        }else{
            $(authorizeElement).innerHTML = 'Remove Flickr Connection';
            $(authorizeElement).set('class', 'fbdisconnect  btn btn-danger');
        }
    };
    
    /**
     * Returns a prebuilt url from the urlbuilder helper to request frobs
     * @returns string url
     */
    var getUrl = function(){
        var url = $(urlbuilderElement).value;
        var urlRequest = new Request.JSON({
            url: url,
            method: 'get',
            data:{'api_key': api_key, 
                'api_secret': api_secret
            },
            onRequest: function(){
            },
            onSuccess: function(response){
                setButtonHref(response);
                //return response.url;
            },
            onFailure: function(response){
                //alert(PLG_SYSTEM_AUTOFBOOK_JS_FAILURE + response.status);
            },
            onComplete: function(response){
                //return response.url;
            }
        });
        urlRequest.cancel().send();
    };
    
    /**
     * Method for clearing and resetting authorisation
     */
    var clearAuthorization = function(){
        $(frobElement).value = '';
        //$(fbPageIdElement).value = '';
        $(authTokenElement).value = '';
        $(authorizeElement).innerHTML = 'Connect to Flikcr';
        setButtonHref();
        $(authTokenElement).fireEvent('change');
    };
    
    /**
     * Method for displaying the connect button when all fields are entered
     */
    var displayButton = function(){
        getUrl();
        if(api_key === '' || api_secret === ''){
            $(authorizeElement).setStyle( 'display', 'none');
        }else{
             //setButtonHref();
            $(authorizeElement).setStyle( 'opacity', '0');
            //$(authorizeElement).setStyle( 'display', 'block');
            $(authorizeElement).fade('in');
        }
    };
    
    /**
     * Method for showing the loader animation
     */
    var showLoader = function(){
        $(authorizeElement).set('html', authElmnt + loader);   
    };
    
    /**
     * Method for hiding the loader animation
     */
    var hideLoader = function(){
        $(authorizeElement).set('html', authElmnt);   
    };
    
    var postAuthorization = function(){
        $(frobElement).value = '';
        //alert(PLG_SYSTEM_AUTOFBOOK_JS_SUCCESS);
        $(authTokenElement).fireEvent('change');
        setButtonHref();
    };
    
    /**
     * Handles the response after successful request
     * @param Object response Response object
     * @returns void
     */
    var handleResponse = function(response){
        if(response.access_token === 'undefined'){
            var errormsg = '(' + response.code + ')' +
                response.type + '\n' +
                response.message;
                alert(errormsg);
        }else{
            $(authTokenElement).value = response.access_token;
            postAuthorization();
        }
    };
    /**
     * Requests an access token
     * @returns void
     */
    var requestAccessToken = function(){
        var reqUrl = helpersURI + 'authorizer.php';
        console.log(reqUrl);
        var myRequest = new Request.JSON({
            url: reqUrl,
            method: 'post',
            data:{'api_key': api_key,
                'api_secret': api_secret,
                'frob': frob
            },
            onRequest: function(){
            },
            onSuccess: function(response){
                handleResponse(response);
            },
            onFailure: function(response){
                alert(PLG_SYSTEM_AUTOFBOOK_JS_FAILURE + response.status);
            },
            onComplete: function(){
                $(authorizeElement).set('html', authElmnt);
            }
        });
        myRequest.cancel().send();    
    };
    /**
     * Initializes the requesting of access token
     * @returns void
     */
    var authorize = function(){
        if(frob !== ''){
            requestAccessToken();
        }
    };
    /**
     * Event Listeners
     */
    $(apiKeyElement).addEvent('keyup', function(){
        api_key = $(apiKeyElement).value;
        displayButton();
    });
    
    $(apiSecretElement).addEvent('keyup', function(){
        api_secret = $(apiSecretElement).value;
        displayButton();
    });
    
    $(frobElement).addEvent('change', function(){
        frob = $(frobElement).value;
        requestAccessToken();
    });
        
    $(authorizeElement).addEvent('click', function(e){
        if($(authTokenElement).value !== ''){
            e.preventDefault();
            clearAuthorization();
        }else{
            showLoader();
        }
    });
    /**
     * Auto fired methods
     */
    authorize();
    displayButton();
});