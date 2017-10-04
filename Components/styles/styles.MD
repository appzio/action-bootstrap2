# Working with styles and style sheets
Styles in Appzio work very similar to CSS styles and most of the notation is identical with CSS. Styles are not however CSS, they get converted to native formatting in iOS and Android. Appzio supports both inline styles and external style sheets.

It is recommended to use the styles.json file instead of the inline styles, as the inline styles increase the client payload significantly. Styles.json file is loaded by the client only when its been updated, so normally clients would get this styles file upon login and they don't need to fetch it again.

Example of style:
```
"message-status-text": {
    "font-size": "10",
    "color": "#949494",
    "text-align": "right",
    "margin": "2 80 2 15"
}
```

### Style files
Style files reside either on the action's main level at styles directory and need to be named with the actions shortname. So if your action is called actionMexample, the style file should be at `styles/Mexample.json`. In most cases styles are at theme's directory at `themes/mytheme/styles/Mexample.json`.

### Inline styles
You can define inline style like this:
```
 $this->getComponentText('My Text',$parameters,array(
   'margin' => '0 40 0 40'
 );
```

General cases where you would use an inline style is when you need to rely on device width for the style definition. For example:
```
 $width = $this->screen_width - 120;
 $margin = '0 ' .$width .' 0 ' .$width;
 
 $this->getComponentText('My Text',$parameters,array(
   'margin' => $margin
 );
```

### Style inheritance
You can use style inheritance in both inline styles and in style sheets. Note though that using multiple inheritances can make debugging more difficult. Using our previous example, you could define it in the following way:
```
 $width = $this->screen_width - 120;
 $margin = '0 ' .$width .' 0 ' .$width;
 
 $this->getComponentText('My Text',$parameters,array(
   'margin' => $margin,
   'parent_style' => 'my_text_style'
 );
```
Or inside the style file:
```
"my_text_style":{
   "font-ios": "Roboto",
   "font-android": "Roboto"
},
"message-status-text": {
    "parent_style": "my_text_style",
    "font-size": "10",
    "color": "#949494",
    "text-align": "right",
    "margin": "2 80 2 15"
}
```

### Supported tags

     * 'margin' => '0 0 0 0'
     * 'padding' => '0 0 0 0'
     * 'width' => '200' // or 100%
     * 'height' => '400'
     * 'max_height' => '500'
     * 'background-color' => '#ffffff'
     * 'background-image' => 'filename.png'
     * 'background-size' => 'cover' // or 'contain' 'top' (default)
     * 'crop' => 'round' // or 'yes'
     * 'vertical-align' => 'middle'
     * 'text-align' => 'center'
     * 'font-size' => '14'
     * 'font-ios' => 'Roboto'
     * 'font-weight' => 'Bold'
     * 'font-style' => 'Italic'
     * 'font-android' => 'Roboto'
     * 'color' => '#000000'
     * 'white-space' => 'nowrap'
     * 'children_style' => 'style-class-name'
     * 'floating' => '1'
     * 'float' => 'right'
     * 'parent_style' => 'style-class-name'
     * 'shadow-color' => '#000000'
     * 'shadow-offset' => '0 1'
     * 'shadow-radius' => '5'
     * 'border-width' => '1'
     * 'border-color' => '#000000'
     * 'border-radius' => '4'
     * 'opacity' => '0.4'
     
### Accessing your app's style information

Various different style files are merged into one and can be accessed with this API call:

`http://{your_server}/api/{you_api_key}/apps/getappstyles?fb_login=false`

Api key you can find from your web dashboard. 

### Overwriting styles

Default component styles can be overriden in your action styles or 