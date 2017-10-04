# Working with images

Appzio supports .png, .jpg and .gif files. Image files are referenced with the file name alone, without any paths. 

Images can be:
* part of the action or action's theme
* uploaded by the client and information saved to database or variable
* referenced with a direct url (in most cases not recommended)
* uploaded from the web interface

In general, images are referred only by their name within the PHP code. Appzio system takes care of copying assets to right places & resizing them.


#### The most basic usage for getting an image:

`$this->getComponentImage('search-icon-for-field.png');`

Getting an image from variables with some parameters:
```
$imageparams['crop'] = 'round';
$imageparams['width'] = '40';
$imageparams['margin'] = '0 10 0 0';
$imageparams['priority'] = 9;
$imageparams['imgwidth'] = 250;
$imageparams['imgheight'] = 250;
$this->getComponentImage($this->getSavedVariable('profilepic'),$imageparams);
```

#### About asset priorities
* 1 = download these assets before client starts
* 2 = download as soon as possible (default)
* 3 … 7 = download whenever action is known to the client
* 7 = download only when needed to show, cache on client only temporarily
* 9 = download only when needed to show, try to deleting after session

Important note: if you are displaying user generated content such as profile pictures or gallery images, it is ALWAYS recommended to set their priority 9. Otherwise this result in the app size increasing significantly, as images also not accessed by the particular client will get added to asset list and client is instructed to download these at the earliest conveniency.

Files referenced with a direct URL are not added to assetlist and are considered priority 9. In most cases its not recommended to hotlink to images directly as they can have significant impact on the app loading times. Images served through Appzio are optimized and can be automatically distributed using a CDN.

#### Getting real image file name
This is useful for example when you need to use the image in a background.
```
$image = $this->getImageFileName($image, array('imgwidth' => 800, 'imgcrop' => 'no');
$this->layout->scroll[] = $this->getComponentText('My text block',array(),array(
   'background-image' => $image,
   'background-size' => 'cover'
);
```

#### Supported image processing parameters
* `imgwidth` in pixels, should not be confused with normal width). Normal width controls simply the display width, whereas imgwidth will resize the actual asset.
* `imgheight`
* `imgcrop` either: yes or round
* `quality` default 70 (refers to jpeg compression)
* `not_to_assetlist` image does not get added to asset list at all
* `mask` takes an image file name that is used for masking the image. Needs to be transparent png for this to work.
* `frame` you can define custom frame for the image. Needs to be transparent png for this to work.
* `blur` applies blur to image


#### Images assetlist
You can access your app's assetlist on the following url

`http://{your_server}/documents/games/{your_apps_numerical_id}/assetlist.json`

You can see your app's numerical ID when you open the app from the web dashboard, it is part of the url. Assetlist contains information like this:
```
[
  {
    "filename": "767ddf78cb8adb8bed1df24e7613ed4d771026ae6c7204b10560fee78f219d80.png",
    "type": "image",
    "branchid": "0",
    "actionid": "0",
    "width": 128,
    "height": 128,
    "md5": "48f657985da7348b6e54fb71b43844d4",
    "size": 1686,
    "prio": "1"
  },
  {
    "filename": "8b7d8424a2a72ae83572e662717cf77821797be1eb39561bf38b49211c624850.png",
    "type": "image",
    "branchid": "6826",
    "actionid": "0",
    "width": 64,
    "height": 64,
    "md5": "5774607da163fa8adc679e942971f08e",
    "size": 505,
    "prio": "1"
  }
]
```

#### Client uploaded images
Client uploads images by default asynchronously. If the image field has variable defined, the client will use the local copy of the uploaded file until it is available from the server. Example of an image upload:

```
if($this->model->getSavedVariable('profilepic')){
    $pic = $this->model->getSavedVariable('profilepic');
} else {
    $pic = 'icon_camera-grey.png';
}

$this->layout->scroll[] = $this->getComponentImage($pic,array(
    'style' => 'mreg_pic',
    'variable' => $this->model->getVariableId('profilepic'),
    'onclick' => $this->getOnclickImageUpload('profilepic',array('max_dimensions' => '900'))
));

```

Synchronous image upload:
```
$this->layout->scroll[] = $this->getComponentImage($pic,array(
    'style' => 'mreg_pic',
    'variable' => $this->model->getVariableId('profilepic'),
    'onclick' => $this->getOnclickImageUpload('profilepic',array('max_dimensions' => '900','sync_upload' => 1))
));

```
