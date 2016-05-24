<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed.'); 

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter
{
    private $twitter;
    private $instance;

    public $status;

    public function __construct() {
        session_start();
        $this->config->load('twitter');
        $this->twitter = $this->config->item('twitter');
        $this->init();
    }

    /**
     * Initialize connection
     * @return [type] [description]
     */
    public function init() {
        $this->instance = new TwitterOAuth($this->twitter['api_key'],
                                        $this->twitter['api_secret']);
    }

    /**
     * Set access tokens / oauth tokens
     */
    public function setAccess() {
        $this->instance->setOauthToken($_SESSION['oauth_token'],
                            $_SESSION['oauth_token_secret']);
    }

    /**
     * Post on twitter timeline
     * @return [type] [description]
     */
    public function post() {
        try {
            if (!isset($this->status) || $this->status == '') 
                throw new Exception('Status is required for this method.', 400);

            $this->setAccess();
            $response = $this->instance->post("statuses/update", array("status" => $this->status) );

            if (isset($response->errors[0]))
                throw new Exception($response->errors[0]->message, $response->errors[0]->code);

            $this->response(array('message' => 'Status posted successfully.',
                    'code' => 200 ));
        } catch (Exception $e) {
            $this->response(array('message' => $e->getMessage(),
                                'code' => $e->getCode()));
        }
    }

    /**
     * Get Oauth token
     * @return [type] [description]
     */
    public function getOauthToken()
    {
        $request_token = $this->instance->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
        return $request_token['oauth_token'];
    }

    /**
     * Get access token
     * @param  [type] $verifier [description]
     * @return [type]           [description]
     */
    public function getAccessToken($verifier)
    {
        $this->setAccess();
        $request_token = $this->instance->oauth('oauth/access_token', array("oauth_verifier" => $verifier ));
        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    }

    /**
     * Get authorize URL
     * @return [type] [description]
     */
    public function oauthUrl() {
        $request_token = $this->getOauthToken();
        $url = $this->instance->url('oauth/authorize', array('oauth_token' => $request_token));
        return $url;
    }

    /**
     * Format response
     * @param  [type] $e [description]
     * @return [type]    [description]
     */
    public function response($e) {
        return $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode(
                            array(  'message'   => $e['message'],
                                    'code'      => (string) $e['code'])
                            ));
    }

    /**
        * Enables the use of CI super-global without having to define an extra variable.
        * I can't remember where I first saw this, so thank you if you are the original author.
        *
        * Copied from the Ion Auth library
        *
        * @access  public
        * @param   $var
        * @return  mixed
    */
    public function __get($var)
    {
        return get_instance()->$var;
    }
}

?>