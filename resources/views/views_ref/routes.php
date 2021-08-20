<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
Route::get('/', 'Front\HomeController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('/CMS/{slug}', 'Front\CMSController@getCMSContent');

//Admin Route

Route::get('admin', ['middleware' => 'auth.admin', 'uses' => 'Admin\LoginController@login']);
Route::post('admin/logincheck', 'Admin\LoginController@loginCheck');
Route::get('admin/dashboard', 'Admin\DashboardController@index');
Route::get('admin/logout', 'Admin\LoginController@getLogout');

// CMS Route
Route::get('admin/cms', 'Admin\CMSManagementController@index');
Route::get('admin/addcms', 'Admin\CMSManagementController@add');
Route::post('admin/savecms', 'Admin\CMSManagementController@save');
Route::get('/getCMS', array('as' => '.getcms', 'uses' => 'Admin\CMSManagementController@getdata'));
Route::get('/data/{id}/edit', array('as' => '.data.edit', 'uses' => 'Admin\CMSManagementController@edit'));
Route::get('/data/{id}/delete', array('as' => '.data.delete', 'uses' => 'Admin\CMSManagementController@delete'));
Route::get('/data/{id}/editinactivecms', array('as' => '.data.editinactivecms', 'uses' => 'Admin\CMSManagementController@editactive'));
Route::get('/data/{id}/editactivecms', array('as' => '.data.editactivecms', 'uses' => 'Admin\CMSManagementController@editinactive'));
Route::get('admin/addauction', 'Admin\AuctionController@index');
Route::post('admin/saveauction', 'Admin\AuctionController@save');
Route::get('admin/auction', 'Admin\AuctionController@auctionlist');
Route::get('/getauction', array('as' => '.getauction', 'uses' => 'Admin\AuctionController@getauction'));
Route::get('/data/{id}/editauction', array('as' => '.data.editauction', 'uses' => 'Admin\AuctionController@edit'));
Route::get('/data/{id}/deleteauction', array('as' => '.data.deleteauction', 'uses' => 'Admin\AuctionController@delete'));


// Email templete Route
Route::get('admin/templates', 'Admin\TemplateManagementController@index');
Route::get('admin/addtemplate', 'Admin\TemplateManagementController@add');
Route::post('admin/savetemplate', 'Admin\TemplateManagementController@save');
Route::get('/getTemplete', array('as' => '.gettemplete', 'uses' => 'Admin\TemplateManagementController@getdata'));
Route::get('/data/{id}/edittemplete', array('as' => '.data.edittemplete', 'uses' => 'Admin\TemplateManagementController@edit'));
Route::get('/data/{id}/deletetemplete', array('as' => '.data.deletetemplete', 'uses' => 'Admin\TemplateManagementController@delete'));
Route::get('/data/{id}/editinactivetemplete', array('as' => '.data.editinactivetemplete', 'uses' => 'Admin\TemplateManagementController@editactive'));
Route::get('/data/{id}/editactivetemplete', array('as' => '.data.editactivetemplete', 'uses' => 'Admin\TemplateManagementController@editinactive'));


//Front User Route for Admin
Route::get('admin/user', 'Admin\UserManagementController@index');
Route::get('admin/adduser', 'Admin\UserManagementController@add');
Route::post('admin/saveuser', 'Admin\UserManagementController@save');
Route::get('/getuser', array('as' => '.getuser', 'uses' => 'Admin\UserManagementController@getdata'));
Route::get('/data/{id}/edituser', array('as' => '.data.edituser', 'uses' => 'Admin\UserManagementController@edit'));
Route::get('/data/{id}/deleteuser', array('as' => '.data.deleteuser', 'uses' => 'Admin\UserManagementController@delete'));
Route::get('/data/{id}/editinactiveuser', array('as' => '.data.editinactiveuser', 'uses' => 'Admin\UserManagementController@editactive'));
Route::get('/data/{id}/editactiveuser', array('as' => '.data.editactiveuser', 'uses' => 'Admin\UserManagementController@editinactive'));
Route::get('/getState/{id}', 'StateCityController@getState');
Route::get('/getcity/{id}', 'StateCityController@getCity');


//voucher Route
Route::get('admin/vouchers', 'Admin\VoucherManagementController@index');
Route::get('admin/addvoucher', 'Admin\VoucherManagementController@add');
Route::post('admin/savevoucher', 'Admin\VoucherManagementController@save');
Route::get('/getVoucher', array('as' => '.getvoucher', 'uses' => 'Admin\VoucherManagementController@getdata'));
Route::get('/data/{id}/editvoucher', array('as' => '.data.editvoucher', 'uses' => 'Admin\VoucherManagementController@edit'));
Route::get('/data/{id}/deletevoucher', array('as' => '.data.deletevoucher', 'uses' => 'Admin\VoucherManagementController@delete'));
Route::get('/data/{id}/editinactivevoucher', array('as' => '.data.editinactivevoucher', 'uses' => 'Admin\VoucherManagementController@editactive'));
Route::get('/data/{id}/editactivevoucher', array('as' => '.data.editactivevoucher', 'uses' => 'Admin\VoucherManagementController@editinactive'));

//Coin Route
Route::get('admin/coins', 'Admin\CoinManagementController@index');
Route::get('admin/addcoin', 'Admin\CoinManagementController@add');
Route::post('admin/savecoin', 'Admin\CoinManagementController@save');
Route::get('/getCoin', array('as' => '.getcoin', 'uses' => 'Admin\CoinManagementController@getdata'));
Route::get('/data/{id}/editcoin', array('as' => '.data.editcoin', 'uses' => 'Admin\CoinManagementController@edit'));
Route::get('/data/{id}/deletecoin', array('as' => '.data.deletecoin', 'uses' => 'Admin\CoinManagementController@delete'));
Route::get('/data/{id}/editinactivecoin', array('as' => '.data.editinactivecoin', 'uses' => 'Admin\CoinManagementController@editactive'));
Route::get('/data/{id}/editactivecoin', array('as' => '.data.editactivecoin', 'uses' => 'Admin\CoinManagementController@editinactive'));

//Daily Coin Route

Route::get('admin/dailycoins', 'Admin\DailycoinManagementController@index');
Route::get('admin/adddailycoin', 'Admin\DailycoinManagementController@add');
Route::post('admin/savedailycoin', 'Admin\DailycoinManagementController@save');
Route::get('/getDailycoin', array('as' => '.getdailycoin', 'uses' => 'Admin\DailycoinManagementController@getdata'));
Route::get('/data/{id}/editdailycoin', array('as' => '.data.editdailycoin', 'uses' => 'Admin\DailycoinManagementController@edit'));
Route::get('/data/{id}/deletedailycoin', array('as' => '.data.deletedailycoin', 'uses' => 'Admin\DailycoinManagementController@delete'));
Route::get('/data/{id}/editinactivedailycoin', array('as' => '.data.editinactivedailycoin', 'uses' => 'Admin\DailycoinManagementController@editactive'));
Route::get('/data/{id}/editactivedailycoin', array('as' => '.data.editactivedailycoin', 'uses' => 'Admin\DailycoinManagementController@editinactive'));

// Admin News Route 
Route::get('admin/news', 'Admin\NewsManagementController@index');
Route::get('admin/addnews', 'Admin\NewsManagementController@add');
Route::post('admin/savenews', 'Admin\NewsManagementController@save');
Route::get('admin/getnews', array('as' => '.getnews', 'uses' => 'Admin\NewsManagementController@getdata'));
Route::get('/data/{id}/editnews', array('as' => '.data.editnews', 'uses' => 'Admin\NewsManagementController@edit'));
Route::get('/data/{id}/deletenews', array('as' => '.data.deletenews', 'uses' => 'Admin\NewsManagementController@delete'));
Route::get('/data/{id}/editinactivenews', array('as' => '.data.editinactivenews', 'uses' => 'Admin\NewsManagementController@editactive'));
Route::get('/data/{id}/editactivenews', array('as' => '.data.editactivenews', 'uses' => 'Admin\NewsManagementController@editinactive'));



// Admin Slider Route 
Route::get('admin/slider', 'Admin\SliderManagementController@index');
Route::get('admin/addslider', 'Admin\SliderManagementController@add');
Route::post('admin/saveslider', 'Admin\SliderManagementController@save');
Route::get('admin/getslider', array('as' => '.getslider', 'uses' => 'Admin\SliderManagementController@getdata'));
Route::get('/data/{id}/editslider', array('as' => '.data.editslider', 'uses' => 'Admin\SliderManagementController@edit'));
Route::get('/data/{id}/deleteslider', array('as' => '.data.deleteslider', 'uses' => 'Admin\SliderManagementController@delete'));
Route::get('/data/{id}/editinactiveslider', array('as' => '.data.editinactiveslider', 'uses' => 'Admin\SliderManagementController@editactive'));
Route::get('/data/{id}/editactiveslider', array('as' => '.data.editactiveslider', 'uses' => 'Admin\SliderManagementController@editinactive'));



// Admin Reward Conversation
Route::get('admin/rewardconversation', 'Admin\RewardConversationManagementController@index');
Route::get('admin/addrewardconversation', 'Admin\RewardConversationManagementController@add');
Route::post('admin/saverewardconversation', 'Admin\RewardConversationManagementController@save');
Route::get('/getRewardConversation', array('as' => '.getRewardConversation', 'uses' => 'Admin\RewardConversationManagementController@getdata'));
Route::get('/data/{id}/editrewardconversation', array('as' => '.data.editrewardconversation', 'uses' => 'Admin\RewardConversationManagementController@edit'));
Route::get('/data/{id}/deleterewardconversation', array('as' => '.data.deleterewardconversation', 'uses' => 'Admin\RewardConversationManagementController@delete'));
Route::get('/data/{id}/editinactiverewardconversation', array('as' => '.data.editinactiverewardconversation', 'uses' => 'Admin\RewardConversationManagementController@editactive'));
Route::get('/data/{id}/editactiverewardconversation', array('as' => '.data.editactiverewardconversation', 'uses' => 'Admin\RewardConversationManagementController@editinactive'));


//Front

Route::get('/contact_us', 'front\ContactUsController@index');

//Front Route

Route::get('login', ['middleware' => 'auth.front', 'uses' => 'Front\LoginController@login']);
Route::post('/logincheck', 'Front\LoginController@loginCheck');
Route::get('/dashboard', 'Front\DashboardController@index');
Route::get('/logout', 'Front\LoginController@getLogout');
Route::get('/signup', 'Front\UserManagementController@signup');
Route::post('/dosignup', 'Front\UserManagementController@doSignup');
Route::get('/completeProfile', 'Front\UserManagementController@completeProfile');
Route::post('/docomplete', 'Front\UserManagementController@doComplete');
Route::get('/verifyUserRegistration', 'Front\LoginController@verifyUserRegistration');
Route::get('/resetUserPassword/{uniqueid}', 'Front\PasswordController@resetUserPassword');
Route::post('/updatePassword', 'Front\PasswordController@updatePassword');
Route::post('/forgotPasswordOTP/{email}', 'Front\PasswordController@forgotPasswordOTP');
Route::post('/saveForgotPassword', 'Front\PasswordController@saveForgotPassword');

Route::get('/forum', 'Front\ForumController@index');
Route::get('/forum/category/{id}', 'Front\ForumController@categoryDetail');
Route::get('/forum/category/topic/{id}', 'Front\ForumController@comment');
Route::post('forum/saveComment', 'Front\ForumController@saveComment');
Route::post('/forum/parentcoment/{id}', 'Front\ForumController@addParentComment');
Route::get('/news', 'Front\NewsController@index');

Route::get('/news/comment/{id}', 'Front\NewsController@newsComment');
Route::post('/news/postcomment', 'Front\NewsController@newsPostComment');



Route::get('/contact_us', function () {
    return view('front.ContactUs');
});
Route::post('contactmail', 'Front\ContactUsController@mail');
Route::post('contactwithoutlogin', 'front\ContactUsController@email');
Route::get('editprofile', 'Front\UserManagementController@editProfile');
Route::post('updateprofile', 'Front\UserManagementController@updateProfile');
Route::post('savecompleteprofile', 'Front\UserManagementController@saveCompleteProfile');


//forum Route 

Route::get('admin/forumcategory', 'Admin\ForumCategoryManagementController@index');
Route::get('admin/addforumcategory', 'Admin\ForumCategoryManagementController@add');
Route::post('admin/saveforumcategory', 'Admin\ForumCategoryManagementController@save');
Route::get('admin/getforumcategory', array('as' => '.getforumcategory', 'uses' => 'Admin\ForumCategoryManagementController@getdata'));
Route::get('/data/{id}/editforumcategory', array('as' => '.data.editforumcategory', 'uses' => 'Admin\ForumCategoryManagementController@edit'));
Route::get('/data/{id}/deleteforumcategory', array('as' => '.data.deleteforumcategory', 'uses' => 'Admin\ForumCategoryManagementController@delete'));
Route::get('/data/{id}/editinactiveforumcategory', array('as' => '.data.editinactiveforumcategory', 'uses' => 'Admin\ForumCategoryManagementController@editactive'));
Route::get('/data/{id}/editactiveforum_category', array('as' => '.data.editactiveforumcategory', 'uses' => 'Admin\ForumCategoryManagementController@editinactive'));

Route::get('admin/forum', 'Admin\ForumManagementController@index');
Route::get('admin/addforum', 'Admin\ForumManagementController@add');
Route::post('admin/saveforum', 'Admin\ForumManagementController@save');
Route::get('admin/getforum', array('as' => '.getforum', 'uses' => 'Admin\ForumManagementController@getdata'));
Route::get('/data/{id}/editforum', array('as' => '.data.editforum', 'uses' => 'Admin\ForumManagementController@edit'));
Route::get('/data/{id}/deleteforum', array('as' => '.data.deleteforum', 'uses' => 'Admin\ForumManagementController@delete'));
Route::get('/data/{id}/editinactiveforum', array('as' => '.data.editinactiveforum', 'uses' => 'Admin\ForumManagementController@editactive'));
Route::get('/data/{id}/editactiveforum', array('as' => '.data.editactiveforum', 'uses' => 'Admin\ForumManagementController@editinactive'));

Route::get('/admin/forumpost/{topicid}', array('as' => '.admin.forumpost', 'uses' => 'Admin\ForumPostManagementController@index'));
Route::get('admin/getforumpost/{topicid}', 'Admin\ForumPostManagementController@getdata');
Route::get('/data/{id}/editforumpost', array('as' => '.data.editforumpost', 'uses' => 'Admin\ForumPostManagementController@edit'));
Route::get('/data/{id}/deleteforumpost', array('as' => '.data.deleteforumpost', 'uses' => 'Admin\ForumPostManagementController@delete'));
Route::get('/data/{id}/editinactiveforumpost', array('as' => '.data.editinactiveforumpost', 'uses' => 'Admin\ForumPostManagementController@editactive'));
Route::get('/data/{id}/editactiveforumpost', array('as' => '.data.editactiveforumpost', 'uses' => 'Admin\ForumPostManagementController@editinactive'));
Route::post('/admin/saveforumpost', 'Admin\ForumPostManagementController@save');

//Product category route
Route::get('admin/productcategory', 'Admin\ProductcategoryManagementController@index');
Route::get('admin/addproductcategory', 'Admin\ProductcategoryManagementController@add');
Route::post('admin/saveproductcategory', 'Admin\ProductcategoryManagementController@save');
Route::get('admin/getproductcategory', array('as' => '.getproductcategory', 'uses' => 'Admin\ProductcategoryManagementController@getdata'));
Route::get('/data/{id}/editproductcategory', array('as' => '.data.editproductcategory', 'uses' => 'Admin\ProductcategoryManagementController@edit'));
Route::get('/data/{id}/deleteproductcategory', array('as' => '.data.deleteproductcategory', 'uses' => 'Admin\ProductcategoryManagementController@delete'));
Route::get('/data/{id}/editinactiveproductcategory', array('as' => '.data.editinactiveproductcategory', 'uses' => 'Admin\ProductcategoryManagementController@editactive'));
Route::get('/data/{id}/editactiveproductcategory', array('as' => '.data.editactiveproductcategory', 'uses' => 'Admin\ProductcategoryManagementController@editinactive'));


//Social provider

Route::get('/facebook', 'SocialAuthController@facebook');
Route::get('facebook/callback', 'SocialAuthController@handleFacebookCallback');
Route::get('facebook/login', 'Front\SocialLoginController@facebookLogin');
Route::get('/google', 'SocialAuthController@google');
Route::get('google/callback', 'SocialAuthController@handleProviderCallback');
Route::any('google/login', 'Front\SocialLoginController@googleLogin');
//General Setting

Route::get('admin/setting', 'Admin\ConfigurationController@index');
Route::get('admin/addsetting', 'Admin\ConfigurationController@add');
Route::post('admin/savesetting', 'Admin\ConfigurationController@save');


//Newscomment Route

Route::get('admin/newscomment{topicid}', 'Admin\NewscommentManagementController@index');
Route::get('admin/addnewscomment', 'Admin\NewscommentManagementController@add');
Route::post('admin/savenewscomment', 'Admin\NewscommentManagementController@save');
Route::get('admin/getnewscomment/{topicid}', 'Admin\NewscommentManagementController@getdata');
//Route::get('/getNewscomment/{topicid}', array('as' => '.getnewscomment', 'uses' => 'Admin\NewscommentManagementController@getdata'));
Route::get('/data/{id}/editnewscomment', array('as' => '.data.editnewscomment', 'uses' => 'Admin\NewscommentManagementController@edit'));
Route::get('/data/{id}/deletenewscomment', array('as' => '.data.deletenewscomment', 'uses' => 'Admin\NewscommentManagementController@delete'));
Route::get('/data/{id}/editinactivenewscomment', array('as' => '.data.editinactivenewscomment', 'uses' => 'Admin\NewscommentManagementController@editactive'));
Route::get('/data/{id}/editactivenewscomment', array('as' => '.data.editactivenewscomment', 'uses' => 'Admin\NewscommentManagementController@editinactive'));
Route::get('/admin/{topicid}/newscomment', array('as' => '.admin.newscomment', 'uses' => 'Admin\NewscommentManagementController@index'));



//Product Route
Route::get('admin/product', 'Admin\ProductManagementController@index');
Route::get('admin/addproduct', 'Admin\ProductManagementController@add');
Route::post('admin/saveproduct', 'Admin\ProductManagementController@save');
Route::get('/getproduct', array('as' => '.getproduct', 'uses' => 'Admin\ProductManagementController@getdata'));
Route::get('admin/product', 'Admin\ProductManagementController@index');
Route::get('/data/editproduct/{id}', array('as' => '.data.editproduct', 'uses' => 'Admin\ProductManagementController@edit'));
Route::get('/data/{id}/deleteproduct', array('as' => '.data.deleteproduct', 'uses' => 'Admin\ProductManagementController@delete'));
Route::get('/data/{id}/editinactiveproduct', array('as' => '.data.editinactiveproduct', 'uses' => 'Admin\ProductManagementController@editactive'));
Route::get('/data/{id}/editactiveproduct', array('as' => '.data.editactiveproduct', 'uses' => 'Admin\ProductManagementController@editinactive'));
Route::get('/getSubCategory/{id}', 'Admin\ProductManagementController@getSubCategory');
Route::get('admin/image/{id}', array('as' => '.image', 'uses' => 'Admin\ProductManagementController@image'));
Route::get('/getproductimage/{productId}', 'Admin\ProductManagementController@getimage');
Route::get('admin/addproductimage/{productId}', 'Admin\ProductManagementController@addimage');
Route::get('/data/editinactiveproductimage/{id}/{pi_product_id}', array('as' => '.data.editinactiveproductimage', 'uses' => 'Admin\ProductManagementController@editactiveimage'));
Route::get('/data/editactiveproductimage/{id}/{pi_product_id}', array('as' => '.data.editactiveproductimage', 'uses' => 'Admin\ProductManagementController@editinactiveimage'));
Route::get('/data/editproductimage/{id}/{pi_product_id}', array('as' => '.data.editproductimage', 'uses' => 'Admin\ProductManagementController@editimage'));
Route::get('/data/deleteproductimage/{id}/{pi_product_id}', array('as' => '.data.deleteproductimage', 'uses' => 'Admin\ProductManagementController@deleteimage'));
Route::post('admin/saveproductimage/{productId}', 'Admin\ProductManagementController@saveimage');
Route::post('/savedata', array('as' => '.savedata', 'uses' => 'Admin\ProductManagementController@saveDate'));


//order history route admin panel
Route::get('admin/order', 'Admin\ProductManagementController@orderHistory');
Route::get('/gethistory', array('as' => '.gethistory', 'uses' => 'Admin\ProductManagementController@getOrderHistoryData'));
Route::post('admin/saveproductimage/{productId}', 'Admin\ProductManagementController@saveimage');
Route::get('/data/{id}/editorderstatus', array('as' => '.data.editorderstatus', 'uses' => 'Admin\ProductManagementController@editorderstatus'));

//RequestAuction Route

Route::post('/saveRequestAction', 'Front\ProductController@saveRequestAuction');
Route::get('/getRequestAction/{userid}/{productid}', 'Front\ProductController@getRequestAuction');
Route::get('admin/request', 'Admin\AuctionController@request');
Route::get('/admin/getrequestedauction', array('as' => '.getrequestedauction', 'uses' => 'Admin\AuctionController@getRequestAuction'));
Route::get('/data/{id}/deleterequest', array('as' => '.data.deleterequest', 'uses' => 'Admin\AuctionController@deleterequete'));



//saveItem Route

Route::post('/saveitem', 'Front\ProductController@saveItem');
Route::get('/getitem/{userid}/{productid}', 'Front\ProductController@getItem');


//addCart Route

Route::post('/saveaddcart', 'Front\ProductController@saveCart');
Route::post('/saveaddcartlimite', 'Front\ProductController@saveCartlimite');
Route::get('/mycart', 'Front\ProductController@myCart');
Route::get('/deletecart/{id}', 'Front\ProductController@deleteCart');
Route::post('/savequantity', 'Front\ProductController@saveQuantity');
Route::post('/placeorder/{id}', 'Front\ProductController@savePlaceOrder');
Route::get('/checkout/{id}/{amount}', 'Front\ProductController@checkout');
Route::post('/checkout/{id}', 'Front\ProductController@saveCheckout');
Route::get('/orderhistory', 'Front\ProductController@orderHistory');
Route::get('/getOrderedProduct', 'Front\ProductController@getOrderedProduct');

Route::get('purchechased', 'Front\ProductController@previoslyPurchadedItems');
Route::get('previouslyvieweditem', 'Front\ProductController@previouslyViewedItem');


//Purchase Voucher Route

Route::get('purchasevoucherhistory', 'Front\VoucherManagementController@index');
Route::post('purchasevoucherhistory', 'Front\VoucherManagementController@index');

//Purchase Coins Route

Route::get('purchasecoinshistory', 'Front\CoinsManagementController@index');
Route::post('purchasecoinshistory', 'Front\CoinsManagementController@index');

Route::get('productdetail/{id}', 'Front\ProductController@productdetail');
Route::get('product', 'Front\ProductController@index');


Route::POST('admin/purchasevoucher', 'Admin\PurchasevoucherManagementController@dateSearch');

Route::get('admin/getpurchasedvoucher','Admin\PurchasevoucherManagementController@getdata');
Route::POST('admin/earnedvoucher', 'Admin\PurchasevoucherManagementController@dateSearchearnvoucher');
Route::get('admin/earnedvoucher', 'Admin\PurchasevoucherManagementController@earnedvoucher');

Route::get('admin/getearnedvoucher','Admin\PurchasevoucherManagementController@getearndvoucherdata');

Route::get('/admin/purchasevoucher', array('as' => '.admin.purchasevoucher', 'uses' => 'Admin\PurchasevoucherManagementController@index'));


//Admin PurchasedCoin Route


Route::POST('admin/purchasecoin', 'Admin\PurchasecoinManagementController@coindateSearch');
Route::get('admin/getpurchasedcoin','Admin\PurchasecoinManagementController@getdata');

Route::get('/data/{id}/editinactivepurchasecoin', array('as' => '.data.editinactivepurchasecoin', 'uses' => 'Admin\PurchasecoinManagementController@editactive'));
Route::get('/data/{id}/editactivepurchasecoin', array('as' => '.data.editactivepurchasecoin', 'uses' => 'Admin\PurchasecoinManagementController@editinactive'));
Route::get('/admin/purchasecoin', array('as' => '.admin.purchasecoin', 'uses' => 'Admin\PurchasecoinManagementController@index'));

Route::get('/getsubcategoryfront/{id}', 'Front\ProductController@getSubCategory');
Route::post('productsearch', 'Front\ProductController@getproductbykeysearch');


//Review Route

Route::get('insertreview', 'Front\ProductController@insertReview');
Route::post('insertreview', 'Front\ProductController@insertReview');

Route::get('productsearch', 'Front\ProductController@getproductbykeysearch');

/*
 * Webservice Route
 */

header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

Route::post('webservice', 'WebService\WebserviceController@index');

// Store -> Saved Items Route

Route::get('saveditems', 'Front\ProductController@getSavedItems');

// Front Auction Route

Route::get('auction', 'Front\AuctionController@index');
Route::post('auction', 'Front\AuctionController@index');
Route::get('liveauction/{id}', ['uses' => 'Front\AuctionController@liveAuction']);
Route::post('addaswatchedItem', 'Front\AuctionController@addAsWatchedItem');
Route::post('insertbidnow', 'Front\AuctionController@insertbidnow');
Route::get('getnetvouchers', ['uses' => 'Front\AuctionController@getnetvouchers']);
Route::get('auctiondetail', 'Front\AuctionController@auctiondetail');
Route::post('newbidprocedure', 'Front\AuctionController@newbidprocedure');
Route::post('newautobidprocedure', 'Front\AuctionController@newautobidprocedure'); 
Route::get('updateauctionstatussold', 'Front\AuctionController@updateauctionstatussold');
Route::get('updateauctionstatuslive', 'Front\AuctionController@updateauctionstatuslive');


Route::get('watcheditems', 'Front\WatchedItemsController@index');
Route::post('watcheditems', 'Front\WatchedItemsController@index');
Route::get('removewatcheditem/{id}', 'Front\WatchedItemsController@removeWatchedItem');
 
/*Route::get('checkforliveauction/{id}', 'Front\WatchedItemsController@checkForLiveAuction'); */
 
Route::get('checkforliveauction/{id}', 'Front\WatchedItemsController@checkForLiveAuction');
Route::get('auctionwon', 'Front\AuctionController@auctionWon');
Route::get('auctionlost', 'Front\AuctionController@auctionLost');
 

/*Event::listen('illuminate.query', function($query)
  {
  var_dump($query);
  });*/


//Payment Route

Route::post('/success','Front\PaymentController@paymentInfo');
Route::get('payment/{id}/{type}','Front\PaymentController@payment');
Route::get('/cancel', 'Front\PaymentController@cancelTransaction');

//Transaction Route

Route::get('admin/transactions', 'Admin\TransactionsController@index');
Route::post('admin/transactions', 'Admin\TransactionsController@index');
Route::get('/gettransaction', array('as' => '.gettransaction', 'uses' => 'Admin\TransactionsController@getdata'));
 

 
Route::get('insertautobid', 'Front\AutoBidController@insertautobid');
 
//NoLiveAuction Route

Route::get('/moredetails/{id}', 'Front\AuctionController@moredetails');



//Game Route

Route::get('admin/game', 'Admin\GameManagementController@index');
Route::get('admin/addgame', 'Admin\GameManagementController@add');
Route::post('admin/savegame', 'Admin\GameManagementController@save');
Route::get('/getgame', array('as' => '.getgame', 'uses' => 'Admin\GameManagementController@getdata'));
Route::get('/data/editgame/{id}', array('as' => '.data.editgame', 'uses' => 'Admin\GameManagementController@edit'));
Route::get('/data/{id}/deletegame', array('as' => '.data.deletegame', 'uses' => 'Admin\GameManagementController@delete'));
Route::get('/data/{id}/editinactivegame', array('as' => '.data.editinactivegame', 'uses' => 'Admin\GameManagementController@editactive'));
Route::get('/data/{id}/editactivegame', array('as' => '.data.editactivegame', 'uses' => 'Admin\GameManagementController@editinactive'));
Route::get('/getGameSubCategory/{id}', 'Admin\GameManagementController@getSubCategory');

//Game category route
Route::get('admin/gamecategory', 'Admin\GamecategoryManagementController@index');
Route::get('admin/addgamecategory', 'Admin\GamecategoryManagementController@add');
Route::post('admin/savegamecategory', 'Admin\GamecategoryManagementController@save');
Route::get('admin/getgamecategory', array('as' => '.getgamecategory', 'uses' => 'Admin\GamecategoryManagementController@getdata'));
Route::get('/data/{id}/editgamecategory', array('as' => '.data.editgamecategory', 'uses' => 'Admin\GamecategoryManagementController@edit'));
Route::get('/data/{id}/deletegamecategory', array('as' => '.data.deletegamecategory', 'uses' => 'Admin\GamecategoryManagementController@delete'));
Route::get('/data/{id}/editinactivegamecategory', array('as' => '.data.editinactivegamecategory', 'uses' => 'Admin\GamecategoryManagementController@editactive'));
Route::get('/data/{id}/editactivegamecategory', array('as' => '.data.editactivegamecategory', 'uses' => 'Admin\GamecategoryManagementController@editinactive'));

//Game fornt Route
Route::get('game', 'Front\GameController@index');
Route::post('gamesearch', 'Front\GameController@getgamebykeysearch');
Route::get('gamesearch', 'Front\GameController@getgamebykeysearch');
Route::get('gamedetail/{id}', 'Front\GameController@gamedetail');
Route::get('insertgamereview', 'Front\GameController@insertGameReview');
Route::post('insertgamereview', 'Front\GameController@insertGameReview');
Route::post('playgame', 'Front\GameController@playGame');
Route::get('savefavoritegame/{id}', 'Front\GameController@favoritegame');
Route::get('savefavoritegamehome/{id}', 'Front\GameController@favoritegamehome');
Route::post('dailycoin', 'Front\GameController@dailycoin');
Route::get('/getfavoritegame/{userid}/{gametid}', 'Front\GameController@getFavoriteGame');
Route::get('favoritegame', 'Front\GameController@favoritegamebyuser');
