{*
//
// Copyright (C) 2005 Smile. All rights reserved.
//
// Authors:
//   Julian Roblin <julian.roblin@smile.fr>
//
// This source file is part of the eZ publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE included in
// the packaging of this file.
//
// Licencees holding a valid "eZ publish professional licence" version 2
// may use this file in accordance with the "eZ publish professional licence"
// version 2 Agreement provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "eZ publish professional licence" version 2 is available at
// http://ez.no/ez_publish/licences/professional/ and in the file
// PROFESSIONAL_LICENCE included in the packaging of this file.
// For pricing of this licence please contact us via e-mail to licence@ez.no.
// Further contact information is available at http://ez.no/company/contact/.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.
//
*}

<div class="block">
<label>{'Preferred number of rows'|i18n( 'design/standard/class/datatype' )}:</label>
<select name="ContentClass_eztext_cols_{$class_attribute.id}">
    <option value="5"  {section show=eq( $class_attribute.data_int1,  5 )}selected="selected"{/section}>5</option>
    <option value="10"  {section show=eq( $class_attribute.data_int1,  10 )}selected="selected"{/section}>10</option>
    <option value="15"  {section show=eq( $class_attribute.data_int1,  15 )}selected="selected"{/section}>15</option>
    <option value="20"  {section show=eq( $class_attribute.data_int1,  20 )}selected="selected"{/section}>20</option>
    <option value="25"  {section show=eq( $class_attribute.data_int1,  25 )}selected="selected"{/section}>25</option>
    <option value="30" {section show=eq( $class_attribute.data_int1, 30 )}selected="selected"{/section}>30</option>
    <option value="35" {section show=eq( $class_attribute.data_int1, 35 )}selected="selected"{/section}>35</option>
    <option value="40" {section show=eq( $class_attribute.data_int1, 40 )}selected="selected"{/section}>40</option>
    <option value="45" {section show=eq( $class_attribute.data_int1, 45 )}selected="selected"{/section}>45</option>
	 <option value="50" {section show=eq( $class_attribute.data_int1, 50 )}selected="selected"{/section}>50</option>
</select>
</div>
