/*!
 *cacc
 * Copyright(c) 2020
 */
  	var winMotivo;
	
		var opcion;
		var tip;
		///////////////////////////////////////
		var storeTipoJustificacion= new Ext.data.JsonStore(
			{   
				url:'../servicesAjax/DSListaTipoJustificacionCBAjax.php',   
				root: 'data',  
				totalProperty: 'total',
				fields: ['codigop', 'nombrep']			
			});		
		storeTipoJustificacion.load();	
			
			var cboTipoJustificacion = new Ext.form.ComboBox(
			{   			
				width : 200,
				x: 80,		
				y : 10,	
				store: storeTipoJustificacion, 
				mode: 'local',
				//autocomplete : true,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'Tipo Justificación...',   
				//triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cbHorario',
				//selectOnFocus: true,
				forceSelection:true,
				cls:"name1",
				listeners: {
					'select': function(cmb,record,index){
							
					}		  
				}		
			});	
			/////////////////////////////////
		var txtFechaApro = new Ext.form.DateField(
		{
			name: 'fechaapp',
			hideLabel: true, 
			maxLength :10,
			width:100,
			readOnly:true,
			x: 80,		
			y : 10,	
			value: new Date().format('d/m/Y'),
			format : 'd/m/Y',
			allowBlank: true,
			style : {textTransform: "uppercase"},			
			enableKeyEvents: true,
			selectOnFocus: true,
			hidden:true,
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						txtm.focus(true, 300);							
					}
				}
			}				
		});
		
		var txtm = new Ext.form.TextArea({
			name: 'motivo11',
			hideLabel: true,	
			maxLength : 200,
			width: 320,
			x: 80,
			y: 40,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name1",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						btnAceptarAp.focus(true, 300);	
					}
				}
			}
		});	
		var txtMotivo22 = new Ext.form.TextArea({
			name: 'motivo22',
			hideLabel: true,	
			maxLength : 200,
			width: 320,
			x: 80,
			y: 45,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						btnAceptarAp.focus(true, 300);	
					}
				}
			}
		});	
			var txtMotivo33 = new Ext.form.TextArea({
			name: 'motivo3',
			hideLabel: true,	
			maxLength : 200,
			width: 320,
			x: 80,
			y: 45,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						btnAceptarAp.focus(true, 300);	
					}
				}
			}
		});	
			
					
		// Labels
		var lbltipojustificacion = new Ext.form.Label({
			text: 'JUSTIFICACION :',
			x: 5,
			y: 15,
			height: 20,
			cls: 'namelabel'
		});
		
		var lblMotivo = new Ext.form.Label({
			text: 'GLOSA :',
			x: 5,
			y: 50,
			height: 20,
			cls: 'namelabel'
		});
		
			
		// botones

		var btnAceptarAp = new Ext.Button({
		    id: 'btnAceptarAp1',
			x: 120,
			y: 120,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmMotivoApro.validarAcceso();
				//pasarM(tip);
				//var frm = frmMotivoApro.getForm();
				//frm.reset();
				//frm.clearInvalid();
				//winMotivo.hide();
			} 
		});		
		
		var btnLimpiarAp = new Ext.Button({
		    id: 'btnLimpiarAp',
			x: 210,
			y: 120,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmMotivoApro.getForm();
				frm.reset();
				frm.clearInvalid();
				winMotivo.hide();
			} 
		});		
		
		var frmMotivoApro = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[  lblMotivo,lbltipojustificacion,  
			        txtFechaApro,cboTipoJustificacion, txtm,
					btnAceptarAp, btnLimpiarAp],
					validarAcceso: function()
					{	if (frmMotivoApro.getForm().isValid()) 
						{
							frmMotivoApro.getForm().submit(
							{	url: '../servicesAjax/DSpasarTipoJustificacion.php', 
									params: {tipo_justificacion: cboTipoJustificacion.getValue()},
									method: 'POST',
									waitTitle: 'Conectando',
									waitMsg: 'Enviando Datos...',
									success: function(form, action)
									{
										pasarM(tip);
										var frm = frmMotivoApro.getForm();
										frm.reset();
										frm.clearInvalid();
										winMotivo.hide();				
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
						else
						{
							Ext.MessageBox.show({
													title: 'ATENCION',
													msg: 'Hay campos obligatorios vacíos. Ingrese los datos correctos para continuar.',
													buttons: Ext.MessageBox.OK,
													selectOnFocus: true,
													icon: Ext.MessageBox.INFO
												});
						}
					}
		});	

		function pasarM(tip)
		{ 
			fechaap1 = txtFechaApro.getValue().format('Y/m/d');
			motivoap1	= txtm.getValue();
			
			LlenarMotivoAprobacione(fechaap1, motivoap1,tip);
			
		}
	
        function MotivoApro(tipo){		
			if (!winMotivo) {
				winMotivo = new Ext.Window({
					layout: 'fit',
					width: 450,
					height:200,		
					title: 'GLOSA JUSTIFICACION ',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,								
					items: [frmMotivoApro],
					listeners: {				
						show: function(){

							txtFechaApro.focus(true, 300);
						}
					}
				});
			}
			tip=tipo;
			if(tip==3 || tip==10)
			cboTipoJustificacion.setDisabled(false);
			else
			cboTipoJustificacion.setDisabled(true);

			var fechaActual = new Date();
			txtFechaApro.setValue(fechaActual);
			txtm.setValue("");
			cboTipoJustificacion.setValue("");
			
			winMotivo.show();
		}
		
		