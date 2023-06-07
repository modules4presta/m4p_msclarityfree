<?php
/**
 * LICENCE
 *
 * ALL RIGHTS RESERVED.
 * YOU ARE NOT ALLOWED TO COPY/EDIT/SHARE/WHATEVER.
 *
 * IN CASE OF ANY PROBLEM CONTACT AUTHOR.
 *
 *  @author    Jakub Przepióra (kontakt@nice-code.eu)
 *  @copyright nice-code.pl
 *  @license   ALL RIGHTS RESERVED
 */
class CustomMenuTab extends mfp_license_manager
{
    private $nameTab;
    private $class_name;
    private $position;

    public function __construct($nameTab, $class_name, $position)
    {
        $this->nameTab = $nameTab;
        $this->class_name = $class_name;
        $this->position = $position;
    }

    public function addTab()
    {
        $tab = new Tab();

        $tab->name = array();

        // Dodajemy nazwę zakładki w różnych językach
        foreach(Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = $this->nameTab;
        }

        $tab->class_name = $this->class_name;
        $tab->module = $this->class_name;
        $tab->id_parent = Tab::getIdFromClassName('AdminParentModules');
//        $tab->position = $this->position;
        $tab->active = true;
        $tab->save();
//        return $tab->add();
    }
    public function addSubTab($nameTab, $class_name, $position)
    {
        // Sprawdzamy, czy zakładka główna istnieje
        $id_parent = Tab::getIdFromClassName($this->class_name);

        if(!$id_parent) {
            throw new Exception('Nie znaleziono zakładki głównej.');
        }

        $sub_tab = new Tab();
        $sub_tab->name = array();

        // Dodajemy nazwę podzakładki w różnych językach
        foreach(Language::getLanguages() as $lang) {
            $sub_tab->name[$lang['id_lang']] = $nameTab;
        }

        $sub_tab->class_name = $class_name;
        $sub_tab->module = $this->class_name;
        $sub_tab->id_parent = $id_parent;
//        $sub_tab->position = $position;
        $sub_tab->active = true;
        $sub_tab->save();
//        return $sub_tab->add();
    }
}