/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

jQuery(function($){
	"use strict";
	
	$(document).on('change', 'select', function() {
		$('option:selected', this).attr('selected',true).siblings().removeAttr('selected');
	});

	$("#style-form").addClass("helix-options");

	$(document).ready(function () {
		/* Remove Basic Fields Joomla 4*/
		if ( joomlaVersion == 4) {
			$(".info-labels").prev("h2").remove();
			$(".info-labels").next("div").remove();
			$(".info-labels").next("hr").addBack().remove();
			$("#jform_params___field1-lbl").closest(".control-group").remove();
		} else {
			/*Remove Basic Fields Joomla 3*/
			$("#details").find(">.row-fluid").find("hr").first().prev().andSelf().remove();
			$("#jform_params___field1-lbl").parent().parent().remove();
			$("#details").find(".control-group").unwrap();
			$("#jform_client_id").parent().removeClass().hide();
		}

		if ( joomlaVersion == 3) {
			$(".info-labels").unwrap();
		} else {
			$('#details .row div.col-lg-9').removeClass("col-lg-9").addClass('col-lg-12');
			$('#details .form-vertical').parent().removeClass("col-lg-3").addClass('hidden');
		}

		$(".group_separator").each(function () {
			$(this).parent().prev().remove();
			$(this).parent().parent().addClass("group-separator");
			$(this).unwrap();
		});

		//Presets
		if ( joomlaVersion == 4) {
			$(".preset").addClass("new-hello").parent().unwrap().prev().remove();
		} else {
			$(".preset").parent().unwrap().prev().remove();
		}
		
		$(".preset").parent().removeClass("controls").addClass("presets clearfix");

		//Load Preset
		$("#attrib-preset")
			.find(".preset-control")
			.each(function () {
				if ($(this).hasClass(current_preset)) {
					$(this).closest(".control-group").show();
				} else {
					$(this).closest(".control-group").hide();
				}
			});

		//Change Preset
		$(".preset").on("click", function (event) {
			event.preventDefault();
			var $that = $(this);

			$(".preset").removeClass("active");
			$(this).addClass("active");

			$("#attrib-preset")
				.find(".preset-control")
				.each(function () {
					if ($(this).hasClass($that.data("preset"))) {
						$(this).closest(".control-group").fadeIn();
					} else {
						$(this).closest(".control-group").hide();
					}
				});

			$("#template-preset").val($that.data("preset"));
		});

		// Change Preset
		$(document).on("blur", ".preset-control", function (event) {
			event.preventDefault();

			var active_preset = $(".preset.active").data("preset");

			if ($(this).attr("id") == "jform_params_" + active_preset + "_major") {
				$(".preset.active").css("background-color", $(this).val());
			}
		});

		// Template Information
		if ( joomlaVersion == 4 ) {
			$("#jform_template").closest(".control-group").appendTo($(".title-alias")).wrap('<div class="col-12 col-md-auto"></div>');
			$("#jform_home1").closest(".control-group").appendTo($(".title-alias")).wrap('<div class="col-12 col-md-auto"></div>');
			$(".title-alias").find(">div:nth-child(2)").remove();
		}
		else
		{
			$("#jform_template").closest(".control-group").appendTo($(".form-inline.form-inline-header"));
			$("#jform_home").closest(".control-group").appendTo($(".form-inline.form-inline-header"));
			$(".info-labels").next().appendTo($("#sp-theme-info"));
			$(".info-labels").prev().addBack().remove();
		}

		// Helix3 Admin Footer
		var footerHtml = '<div class="helix-footer-area">';
		footerHtml += '<div class="clearfix">';
		footerHtml +=
			'<a class="helix-logo-area" href="https://www.joomshaper.com/helix" target="_blank">Helix3 Logo</a>';
		footerHtml += '<span class="template-version">' + pluginVersion + "</span>";
		footerHtml += "</div>";
		footerHtml += '<div class="help-links">';
		footerHtml +=
			'<a href="https://www.joomshaper.com/documentation/helix-framework/helix3" target="_blank">' + Joomla.Text._('HELIX_DOCUMENTATION') + '</a><span>|</span>';
		footerHtml +=
			'<a href="https://www.facebook.com/groups/819713448150532/" target="_blank">' + Joomla.Text._('HELIX_COMMUNITY') + '</a><span>|</span>';
		footerHtml +=
			'<a href="https://www.joomshaper.com/page-builder" target="_blank">Page Builder Pro</a><span>|</span>';
		footerHtml +=
			'<a href="https://www.joomshaper.com/joomla-templates" target="_blank">' + Joomla.Text._('HELIX_PREMIUM_TEMPLATES') + '</a><span>|</span>';
		footerHtml += '<a href="https://www.joomshaper.com/joomla-extensions" target="_blank">' + Joomla.Text._('HELIX_JOOMLA_EXTENSIONS') + '</a>';
		footerHtml += "</div>";
		footerHtml += "</div>";

		$(footerHtml).insertAfter("#style-form");
	});

	if (joomlaVersion == 3) {
		// Media Button
		$(".input-prepend, .input-append").find(".btn").each(function () {
			if ($(this).is(".modal, .button-select")) {
				$(this).addClass("btn-success");
			} else {
				$(this).addClass("btn-danger");
			}
		});

		$(".controls").find(".field-media-preview").each(function () {
			$(this).insertBefore($(this).parent().find(".input-append"));
		});

		$(".control-group .field-media-preview").not("img").each(function () {
			$(this).append('<div id="preview_empty">' + Joomla.Text._('HELIX_NO_IMAGE_SELECTED') + '</div>');
		});

		// clear image
		$(".helix-options .controls .field-media-wrapper .input-append").on("click", ".button-clear", function (event) {
			$(this).closest(".field-media-wrapper").find(".field-media-preview").html('<div id="preview_empty">' + Joomla.Text._('HELIX_NO_IMAGE_SELECTED') + '</div>');
		});

		// Add .btn-group class
		$(".radio").addClass("btn-group");
	}

	// Import Template Settings
	$(document).on("click", "#import-settings", function (event) {
		event.preventDefault();

		var $that = $(this),
			template_id = $that.data("template_id"),
			temp_settings = $.trim($that.prev().val());

		if (temp_settings == "") {
			return false;
		}

		if (confirm(Joomla.Text._('HELIX_CHANGE_CURRENT_SETTINGS')) != true) {
			return false;
		}

		var data = {
			action: "import",
			template_id: template_id,
			settings: temp_settings,
		};

		var request = {
			option: "com_ajax",
			plugin: "helix3",
			data: data,
			format: "json",
		};

		$.ajax({
			type: "POST",
			data: request,
			success: function (response) {
				window.location.reload();
			},
			error: function () {
				alert(Joomla.Text._('HELIX_ALERT_WRONG'));
			},
		});
		return false;
	});
});