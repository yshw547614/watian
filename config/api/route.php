<?php
/**
 * 路由注册
 *
 * 以下代码为了尽量简单，没有使用路由分组
 * 实际上，使用路由分组可以简化定义
 * 并在一定程度上提高路由匹配的效率
 */
// 写完代码后对着路由表看，能否不看注释就知道这个接口的意义
use think\Route;

//Miss 404
//Miss 路由开启后，默认的普通模式也将无法访问
//Route::miss('api/v1.Miss/miss');

//Banner
Route::get('api/banner', 'api/Advert/getAdvert');
Route::get('api/advert/list', 'api/Advert/getList');
Route::get('api/advert/detail', 'api/Advert/getDetail');

//Images
Route::get('api/image/info', 'api/Image/getImageById');
Route::get('api/image/weixin', 'api/Image/getWeixinImg');

//Images
Route::get('api/slogan/list', 'api/Slogan/getList');

//Product
Route::get('api/product/by_category/paginate', 'api/Product/getByCategory');
Route::get('api/product/by_category', 'api/Product/getAllInCategory');
Route::get('api/product/:id', 'api/Product/getOne',[],['id'=>'\d+']);
Route::get('api/product/recent', 'api/Product/getRecent');
Route::get('api/product/user', 'api/Product/userProductStore');
Route::get('api/search/keyword', 'api/Keyword/getKeyword');
Route::get('api/product/user_keyword', 'api/Keyword/getUserKeyword');
Route::get('api/product/similarity', 'api/Product/getSimilarity');
Route::get('api/product/recommend/home', 'api/Product/homeRecommend');
Route::post('api/product/check/invalid', 'api/Product/checkInvalidProduct');

//Config
Route::get('api/word/wechat/attention', 'api/Config/attentionWechatWord');
Route::get('api/word/app/download', 'api/Config/downlowAppWord');


//ProductComment
Route::get('api/product/comment/add', 'api/ProductComment/getCommentProduct');
Route::post('api/product/comment/add', 'api/ProductComment/addComment');
Route::get('api/product/comment/count', 'api/ProductComment/getCommentCount');
Route::get('api/product/comment/user', 'api/ProductComment/userCommentCount');
Route::get('api/product/comment/praise', 'api/ProductComment/updatePraise');
Route::get('api/product/comment/will', 'api/ProductComment/getWillEvaluateProduct');
Route::get('api/product/comment/already', 'api/ProductComment/getEvaluatedProduct');
Route::get('api/product/comment/brief_info', 'api/ProductComment/getProductByOrderProductid');
Route::get('api/product/comment', 'api/ProductComment/getComments');

//Express
Route::get('api/express/get', 'api/Express/getExpress');
Route::get('api/express/get/international', 'api/Express/getInternationalExpress');

//AfterService
Route::get('api/service/get', 'api/AfterService/getOneAfterService');
Route::get('api/service/apply/list', 'api/AfterService/getCanApplyList');
Route::post('api/service/apply/submit', 'api/AfterService/apply');
Route::get('api/service/cancel', 'api/AfterService/cancelAplly');
Route::get('api/service/list', 'api/AfterService/getUserAfterService');
Route::post('api/service/delivery','api/AfterService/delivery');
Route::get('api/service/reason', 'api/AfterService/getReturnReason');
Route::get('api/service/address', 'api/AfterService/getStoreAddress');

//Category
Route::get('api/category', 'api/Category/getCategories');//获取顶级类目下的二级类目
Route::get('api/category/all', 'api/Category/getTopCategories');//获取所有顶级顶级类目
Route::get('api/category/home', 'api/Category/getHomeCategory');//商城首页数据列表
Route::get('api/category/nav', 'api/Navigation/getNav');//商城首页数据导航

//IdentifyCard
Route::post('api/identify/submit', 'api/IdentifyCard/handle');
Route::get('api/identify/one', 'api/IdentifyCard/getOne');
Route::get('api/identify/all', 'api/IdentifyCard/getAll');
Route::get('api/identify/del', 'api/IdentifyCard/del');
Route::get('api/identify/set_default', 'api/IdentifyCard/setDefault');
Route::get('api/identify/get_default', 'api/IdentifyCard/getDefault');


//Token
Route::post('api/token/user', 'api/Token/getToken');

Route::post('api/token/app', 'api/Token/getAppToken');
Route::post('api/token/verify', 'api/Token/verifyToken');
Route::post('api/user/weixin', 'api/User/getUserWxInfo');

//Address
Route::get('api/address', 'api/Address/getUserAddress');
Route::post('api/address', 'api/Address/createOrUpdateAddress');


//Order
Route::post('api/order', 'api/Order/placeOrder');
Route::get('api/order/:id', 'api/Order/getDetail',[], ['id'=>'\d+']);
Route::get('api/order/cancel', 'api/Order/cancelOrder');
Route::get('api/order/delete', 'api/Order/deleteOrder');
Route::post('api/order/calculate', 'api/Order/calculateOrderPrice');
Route::post('api/order/real_price', 'api/Order/calculateRealPrice');

//不想把所有查询都写在一起，所以增加by_user，很好的REST与RESTFul的区别
Route::get('api/order/by_user', 'api/Order/getSummaryByUser');
Route::get('api/order/paginate', 'api/Order/getSummary');

//Pay
Route::post('api/pay/pre_order', 'api/Pay/getPreOrder');
Route::post('api/pay/notify', 'api/Pay/receiveNotify');
Route::post('api/pay/re_notify', 'api/Pay/redirectNotify');
Route::post('api/pay/concurrency', 'api/Pay/notifyConcurrency');

//Help
Route::get('api/help/category', 'api/Help/getCategory');
Route::get('api/help/list', 'api/Help/getList');
Route::get('api/help/detail', 'api/Help/getDetail');

//Message
Route::post('api/message/delivery', 'api/Message/sendDeliveryMsg');

//User
Route::get('api/user/info', 'api/User/getUserDetail');
Route::get('api/user/:id', 'api/User/getUserDetailById',[], ['id'=>'\d+']);
Route::get('api/user/list', 'api/User/getUserList');
Route::get('api/msg/num', 'api/User/countUserMsg');

//Album
Route::post('api/album/add', 'api/Album/add');
Route::post('api/edit/headimg', 'api/UserEdit/editHeadImg');

//Certificate
Route::get('api/certificate/list', 'api/Certificate/getCertificate');
Route::post('api/certificate/add', 'api/Certificate/add');
Route::post('api/certificate/edit', 'api/Certificate/edit');


