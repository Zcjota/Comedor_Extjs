/*!
 * DSoft-RBJ
 * Copyright(c) 2012
 */
  	var winTarjeta;

		var codigo;
		var opcion;
		var txtCodigoTarjeta = new Ext.form.NumberField({
				allowDecimals: true,
				allowBlank: false,
				allowNegative: false,
				name: 'nro',
				hideLabel: true,
				maxLength : 20,
				align: 'right',
				width: 80,
				x: 120,
				y: 10,
				value : 0,
				style : {textTransform: "uppercase"},
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){

						}
					}
				}
		});
		var txtNombre = new Ext.form.TextField({
				name: 'nombre',
				hideLabel: true,
				width: 250,
				x: 120,
				y: 40,
				allowBlank: false,
				maxLength:100,
				style : {textTransform: "uppercase"},
				blankText: 'Nombre requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){

						}
					}
				}
		});
		var storeSubcentro= new Ext.data.JsonStore(
		{
			url:'../servicesAjax/DSListaSubCentroCBAjax.php',
			root: 'data',
			totalProperty: 'total',
			fields: ['codigop', 'nombrep'],
			listeners: {
					load: function(thisStore, record, ids)
					{
							cboSubCentro.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('cod_subcentro'));
							storecentro.load({params:{cbUnidad: cboUnidad.getValue(),cbSubCentro: cboSubCentro.getValue()}});
					}
			}
		});
		var cboSubCentro= new Ext.form.ComboBox(
		{
			x: 120,
			y: 100,
			width : 250,
			store: storeSubcentro,
			mode: 'local',
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione SUBCENTRO...',
			triggerAction: 'all',
			displayField:'nombrep',
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbsubcentro',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {

				 'select': function(cmb,record,index){
							cboCentro.setValue('');
							storecentro.load({params:{cbUnidad: cboUnidad.getValue(),cbSubCentro: cboSubCentro.getValue()}});
							cboCentro.focus(true, 300);
							cboCentro.enable(false);
				}
			}
			});
		var storeUnidad= new Ext.data.JsonStore(
		{
			url:'../servicesAjax/DSListaUnidadCBAjax.php',
			root: 'data',
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']
		});
		storeUnidad.load();

		var cboUnidad = new Ext.form.ComboBox(
		{
			x: 120,
			y: 70,
			width : 250,
			store: storeUnidad,
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione UNIDAD...',
			triggerAction: 'all',
			displayField:'nombrep',
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbunidad',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
					  'select': function(cmb,record,index){
							cboSubCentro.setValue('');
							cboCentro.setValue('');
							storeSubcentro.load({params:{cbUnidad: cboUnidad.getValue()}});

							cboSubCentro.focus(true, 300);
							 cboSubCentro.enable(false);
						}
			}
			});
		var storecentro= new Ext.data.JsonStore(
		{
			url:'../servicesAjax/DSListaCentroCBAjax.php',
			root: 'data',
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']	,
			listeners: {
					load: function(thisStore, record, ids)
					{

					}
			}
		});
		// storecentro.load();
		var cboCentro= new Ext.form.ComboBox(
		{
			x: 120,
			y: 130,
			width : 250,
			store: storecentro,
			mode: 'remote',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione CENTRO...',
			triggerAction: 'all',
			displayField:'nombrep',
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbcentro',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {


			}
		});
		// Labels

		var lblNroTarjeta = new Ext.form.Label({
			text: 'CODIGO TARJETA :',
			x: 10,
			y: 15,
			height: 20,
			cls: 'namelabel'
		});

		var lblNombre = new Ext.form.Label({
			text: 'NOMBRE TARJETA :',
			x: 10,
			y: 45,
			height: 20,
			cls: 'namelabel'
		});

		var lblUnidad = new Ext.form.Label({
			text: 'UNIDAD :',
			x: 10,
			y: 75,
			height: 20,
			cls: 'namelabel'
		});
		var lblSubcentro = new Ext.form.Label({
			text: 'SUBCENTRO :',
			x: 10,
			y: 105,
			height: 20,
			cls: 'namelabel'
		});
		var lblcentro = new Ext.form.Label({
			text: 'CENTRO :',
			x: 10,
			y: 135,
			height: 20,
			cls: 'namelabel'
		});
		// botones
		var btnAceptar = new Ext.Button({
		    id: 'btnAceptar',
			x: 120,
			y: 130,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmTarjeta.guardarDatos();
			}
		});

		var btnLimpiar = new Ext.Button({
		    id: 'btnLimpiar',
			x: 200,
			y: 130,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmTarjeta.getForm();
				frm.reset();
				frm.clearInvalid();
				winTarjeta.hide();
			}
		});

		var frmTarjeta = new Ext.FormPanel({
			frame:true,
			layout: 'absolute',
			items:[	lblNroTarjeta,lblNombre,lblUnidad,lblSubcentro,lblcentro,
					txtCodigoTarjeta,txtNombre,cboUnidad,cboSubCentro,cboCentro
			],
			guardarDatos: function(){
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSabmTarjetaAjax.php',
						params :{codigo: codigo, opcion: opcion},
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
								var frm = frmTarjeta.getForm();
								frm.reset();
								frm.clearInvalid();
								winTarjeta.hide();

								Ext.dsdata.storeTarjeta.load({params:{start:0,limit:25}});
						},
						failure: function(form, action){
							if (action.failureType == 'server') {
								var data = Ext.util.JSON.decode(action.response.responseText);
								Ext.Msg.alert('No se pudo conectar', data.errors.reason, function(){
									//txtDescripcion.focus(true, 100);
								});
							}
							else {
								Ext.Msg.alert('Error!', 'Imposible conectar con servidor : ' + action.response.responseText);
							}
						}
					});
				}
				else
				{
					Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Algunos campos son obligatorios.</a>');
				}
			}
		});

        function NuevaTarjeta(){

			if (!winTarjeta) {

				winTarjeta = new Ext.Window({
					layout: 'fit',
					width: 450,
					height: 240,
					title: 'REGISTRAR TARJETA',
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,
					items: [frmTarjeta],
					buttonAlign:'center',
					buttons:[btnAceptar, btnLimpiar],
					listeners: {
						show: function(){
							//txtDescripcion.focus(true, 300);
						}
					}
				});
			}
			txtCodigoTarjeta.setValue("");
			txtNombre.setValue("");
			cboUnidad.setValue("");
			cboSubCentro.setValue("");
			cboCentro.setValue("");

			opcion = 0;
			winTarjeta.show();
		}

		function modTarjeta(indice){
			if (!winTarjeta) {
				winTarjeta = new Ext.Window({
					layout: 'fit',
					width: 450,
					height: 240,
					title: 'TARJETA',
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,
					items: [frmTarjeta],
					buttonAlign:'center',
					buttons:[btnAceptar, btnLimpiar],
					listeners: {
						show: function(){

						}
					}
				});
			}
			opcion = 1;
			storeSubcentro.load({params:{cbUnidad: Ext.dsdata.storeTarjeta.getAt(indice).get('unidad')}});
			storecentro.load({params:{cbUnidad: Ext.dsdata.storeTarjeta.getAt(indice).get('unidad'),cbSubCentro:Ext.dsdata.storeTarjeta.getAt(indice).get('subcentro')}});
			codigo = Ext.dsdata.storeTarjeta.getAt(indice).get('codigo');
			txtCodigoTarjeta.setValue(codigo);
			txtNombre.setValue(Ext.dsdata.storeTarjeta.getAt(indice).get('descripcion'));
			cboUnidad.setValue(Ext.dsdata.storeTarjeta.getAt(indice).get('unidad'));
			 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
						 window.setTimeout(function()
						 {
								cboSubCentro.setValue(Ext.dsdata.storeTarjeta.getAt(indice).get('subcentro'));
								cboCentro.setValue(Ext.dsdata.storeTarjeta.getAt(indice).get('centro'));
									Ext.Msg.hide();
						},3000);


			winTarjeta.show();

		}
