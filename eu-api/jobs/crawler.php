<?php

$categories = [
  '女装' => [
      '上衣' => ['背心','卫衣','T恤','衬衫','开衫','毛衣','夹克','风衣','西装','羽绒服','棉衣','秋衣','休闲外套','大衣','马甲'],
      '裤装' => ['牛仔裤','运动裤','紧身裤','休闲裤','休闲短裤','海滩裤'],
      '裙装' => ['连衣裙','牛仔裙','背带裙','短裙','毛衣裙'],
      '特色服饰' => ['时尚套装','运动套装','中老年服饰','民族服装']
  ],
    '男装' => [
        '上衣' => ['背心','卫衣','T恤','衬衫','  POLO衫','毛衣','夹克','风衣','西装','羽绒服','棉衣','秋衣','休闲外套','大衣','马甲'],
        '裤装' => ['牛仔裤','运动裤','休闲裤','休闲短裤','海滩裤'],
        '特色服饰' => ['时尚套装','运动套装','西装']
    ],
    '鞋靴' => [
        '男鞋' => ['男皮鞋','运动鞋','布鞋','拖鞋','雨鞋','凉鞋','男靴休闲鞋','足球鞋'],
        '女鞋' => ['女皮鞋','运动鞋','拖鞋','凉鞋','单鞋','女靴布鞋','雨鞋','时装鞋','休闲鞋','足球鞋'],
        '童鞋' => ['皮鞋','运动鞋','凉鞋','靴子休闲鞋']
    ],
    '童装' => [
        '上衣' => ['背心','卫衣','T恤','衬衫','开衫','毛衣','夹克','风衣','西装','羽绒服','棉衣','秋衣','休闲外套','大衣','马甲'],
        '裤装' => ['牛仔裤','运动裤','紧身裤','休闲裤','休闲短裤','海滩裤'],
        '裙装' => ['连衣裙','牛仔裙','背带裙','短裙','毛衣裙'],
        '特色服饰' => ['时尚套装','运动套装','中老年服饰','民族服装']
    ],
    '箱包手袋' => ['旅行箱', '书包','腰包', '背包','挎包','手提包', '办公包','单肩包','钱包','手机包','旅行袋','化妆包','拉杆包','登山包','电脑包','胸包'],
    '家纺窗帘' => ['地毯','桌布','毛巾','海滩巾','沙发套','椅子垫'],
    '收拾配饰围巾' => ['手表','首饰','假发','女士丝巾/围巾/披肩','皮带','领带','领结','帽子','腰带'],
    '内衣睡衣袜子' => ['文胸','内裤','泳装','睡衣','情趣内衣','袜子','汗衫','瘦身衣'],
];

//        foreach ($categories as $key => $val) {
//            $model = new ProductCategories();
//            $model->name = $key;
//            $model->type = 1;
//            $model->parent_id = 0;
//            $model->save();
//            $parent = ProductCategories::findOne(['name' => $key]);
//            $parentId = $parent->id;
//            foreach ($val as $v => $t) {
//                if(count($val[$v]) > 1) {
//                    $model = new ProductCategories();
//                    $model->name = $v;
//                    $model->type = 2;
//                    $model->parent_id = $parentId;
//                    $model->save();
//                    $p = ProductCategories::findOne(['name' => $v, 'parent_id' => $parentId]);
//                    $pid = $p->id;
//                    foreach($val[$v] as $type) {
//                        $model = new ProductCategories();
//                        $model->name = $type;
//                        $model->type = 3;
//                        $model->parent_id = $pid;
//                        $model->save();
//                    }
//                } else {
//                    $model = new ProductCategories();
//                    $model->name = $t;
//                    $model->type = 2;
//                    $model->parent_id = $parentId;
//                    $model->save();
//                }
//            }
//        }