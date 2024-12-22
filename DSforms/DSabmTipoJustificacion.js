/*!
 * CACC
 * Copyright(c) 2020
 */
	var winTipoJustificacion;	
		var codigo;
		var opcion;// = 1; //1=alta; 2= modificar
		var foto;
	 var txtnombre = new Ext.form.TextField({
				name: 'txtnombre',
				maxLength : 150,
				width: 260,
				x: 120,
				y: 10,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls: 'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
						}
					}
				}
		});	
  // Labels
    var lblnombre = new Ext.form.Label({
		text: 'NOMBRE :',
		x: 10,
		y: 10,
		height: 20,
		cls: 'namelabel'
	});
	
	var btnAceptar = new Ext.Button({
		id: 'btnAceptar',
		x: 110,
		y: 70,
		text: 'Aceptar',
		icon: '../img/save.png',
		iconCls: 'x-btn-text-icon',
		minWidth: 80,
		handler:function(){
			frmTipoJustificacion.validarAcceso();				
		} 
	});
	var btnLimpiar = new Ext.Button({
		id: 'btnLimpiar',
		x: 200,
		y: 70,
		text: 'Cancelar',
		icon: '../img/delete.png',
		iconCls: 'x-btn-text-icon',
		minWidth: 80,
		handler:function()
		{				
			var frm = frmTipoJustificacion.getForm();
			frm.reset();
			frm.clearInvalid();
			winTipoJustificacion.hide();
		} 
	});				
	var frmTipoJustificacion = new Ext.FormPanel(
	{ 
		frame:true, 		
		layout: 'absolute',
		autoScroll:false,
		items:[
			     lblnombre,
				 txtnombre
			  ],
		validarAcceso: function()
		{	if (this.getForm().isValid()) 
			{	this.getForm().submit(
				{	url: '../servicesAjax/DSABMTipoJustificacionAJAX.php', 
					params: {codigo: codigo,opcion:opcion},
					method: 'POST',
					waitTitle: 'Conectando',
					waitMsg: 'Enviando Datos...',
					success: function(form, action)
					{
						var frm=frmTipoJustificacion.getForm();
						frm.reset();
						frm.clearInvalid();
						winTipoJustificacion.hide();
							
						Ext.dsdata.storeTipoJustificacion.load({params:{start:0,limit:25}});				
					},					
					failure: function(form, action)
					{if (action.failureType == 'server') 
						{	var data = Ext.util.JSON.decode(action.response.responseText);
							Ext.Msg.alert('BUGS', data.errors.reason, function()
							{
								
							});
						}
						else 
						{
							Ext.Msg.alert('Error!', 'Imposible conectar con servidor : ' + action.response.responseText);
						}
						
					}
				});
			}
		}
	});		
	function AltaTipoJustificacion()
	{		
		if (!winTipoJustificacion) 
		{
			winTipoJustificacion = new Ext.Window(
			{
				layout: 'fit',
				width: 450,
				height: 150,		
				title: 'TIPO DE JUSTIFICACION',			
				resizable: false,
				closeAction: 'hide',
				closable: true,
				draggable: false,
				plain: true,
				border: false,
				modal: true,					
				items: [frmTipoJustificacion],
				buttonAlign:'center',
					buttons:[btnAceptar, btnLimpiar],
				listeners: {												
					show: function()
					{
						txtnombre.focus();
						
					}
				}
			});
		} 			
		txtnombre.setValue("");
		opcion = 0;
		winTipoJustificacion.show();
	}			
    function ModTipoJustificacion(ind)
	{		
		if (!winTipoJustificacion) 
		{
			winTipoJustificacion = new Ext.Window(
			{
				layout: 'fit',
				width: 450,
				height: 150,		
				title: 'TIPO DE JUSTIFICACION',
				resizable: false,
				closeAction: 'hide',
				closable: true,
				draggable: false,
				plain: true,
				border: false,
				modal: true,					
				items: [frmTipoJustificacion],
				buttonAlign:'center',
					buttons:[btnAceptar, btnLimpiar],
				listeners: {												
					show: function()
					{
						txtnombre.focus();
						
					}
				}
			});
		} 
		 codigo = Ext.dsdata.storeTipoJustificacion.getAt(ind).get('_id'); 
		txtnombre.setValue(Ext.dsdata.storeTipoJustificacion.getAt(ind).get('nombre'));
		opcion = 1;
		winTipoJustificacion.show();
	}	
	
			