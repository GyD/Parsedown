# Parsedown for Vanilla
A simple implementation of Parsedown and Parsedown-Extra for Vanilla

# How to Use
* Get the latest release
* Extract the file and place the *Parsedown* folder into your plugin folder
* Enable the plugin
* Change the input formater into your configuration file:
```php
$Configuration['Garden']['InputFormatter'] = 'ParsedownExtra';
```

# Settings
## Automatic line breaks
You can enables automatic line breaks by setting `Plugins.Parsedown.BreaksEnabled` to true:
```php
$Configuration['Plugins']['Parsedown']['BreaksEnabled'] = true';
```

## Escapes markup (HTML)
You can enables escapes markup (HTML) by setting `Plugins.Parsedown.markupEscaped` to true:
```php
$Configuration['Plugins']['Parsedown']['markupEscaped'] = true';
```