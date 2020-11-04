/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){
   jQuery('.clickable-row').click(function(){
       //window.location=jQuery(this).data('href');
       window.open(jQuery(this).data('href'),'_blank');
   });
});

