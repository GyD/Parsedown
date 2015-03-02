<?php if (!defined('APPLICATION')) {
    exit();
}
/*
  Copyright 2008, 2009 Vanilla Forums Inc.
  This file is part of Garden.
  Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
  Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
  You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.
  Contact Vanilla Forums Inc. at support [at] vanillaforums [dot] com
 */

$PluginInfo['Parsedown'] = array(
  'Description' => 'Adapts The New BBCode Parser to work with Vanilla.',
  'Version' => '1.0.1',
  'RequiredApplications' => array('Vanilla' => '2.1.8p2'),
  'RequiredTheme' => false,
  'RequiredPlugins' => false,
  'HasLocale' => false,
  'Author' => "GyD",
  'AuthorEmail' => 'contact@gyd.be',
  'AuthorUrl' => 'https://github.com/GyD'
);


Gdn::FactoryInstall('ParsedownFormatter', 'ParsedownPlugin', __FILE__, Gdn::FactorySingleton);
Gdn::FactoryInstall('ParsedownExtraFormatter', 'ParsedownPlugin', __FILE__, Gdn::FactorySingleton);

class ParsedownPlugin extends Gdn_Plugin
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $Result
     * @return mixed
     */
    public function Format($Result)
    {
        $this->EventArguments['Result'] = $Result;

        $this->FireEvent('BeforeParsedownFormat');

        $Result = $this->EventArguments['Result'];

        $Result = $this->Parser()
          ->text($Result);

        $Result = Gdn_Format::Links($Result);
        $Result = Gdn_Format::Mentions($Result);

        return $Result;
    }

    /**
     * @return Parsedown|ParsedownExtra
     */
    private function Parser()
    {
        static $formatter;

        if (null != $formatter) {
            return $formatter;
        }

        require_once __DIR__ . '/lib/parsedown/Parsedown.php';

        switch (C('Garden.InputFormatter')) {
            case 'ParsedownExtra':
                require_once __DIR__ . '/lib/parsedown-extra/ParsedownExtra.php';
                $formatter = new ParsedownExtra();;
                break;
            case 'Parsedown':
            default:
                $formatter = new Parsedown();
                break;
        }

        // Enable breaklines if settings is set to true
        if (C('Plugins.Parsedown.BreaksEnabled', false)) {
            $formatter->setBreaksEnabled(true);
        }

        // Enable markupEscaped if settings is set to true
        if (C('Plugins.Parsedown.markupEscaped', false)) {
            $formatter->setMarkupEscaped(true);
        }

        // Don't link urls, let's use the Garder Links Formatter
        $formatter->setUrlsLinked(false);

        return $formatter;
    }
}