<?php
namespace W3TC;

if ( ! defined( 'W3TC' ) ) {
	die();
}
?>
<tr>
	<th style="width: 300px;"><label for="cdn_azure_user"><?php esc_html_e( 'Account name:', 'w3-total-cache' ); ?></label></th>
	<td>
		<input id="cdn_azure_user" class="w3tc-ignore-change" type="text"
			<?php Util_Ui::sealing_disabled( 'cdn.' ); ?> name="cdn__azure__user" value="<?php echo esc_attr( $this->_config->get_string( 'cdn.azure.user' ) ); ?>" size="30" />
	</td>
</tr>
<tr>
	<th><label for="cdn_azure_key"><?php esc_html_e( 'Account key:', 'w3-total-cache' ); ?></label></th>
	<td>
		<input id="cdn_azure_key" class="w3tc-ignore-change"
			<?php Util_Ui::sealing_disabled( 'cdn.' ); ?> type="password" name="cdn__azure__key" value="<?php echo esc_attr( $this->_config->get_string( 'cdn.azure.key' ) ); ?>" size="60" />
	</td>
</tr>
<tr>
	<th><label for="cdn_azure_container"><?php esc_html_e( 'Container:', 'w3-total-cache' ); ?></label></th>
	<td>
		<input id="cdn_azure_container" type="text"
			<?php Util_Ui::sealing_disabled( 'cdn.' ); ?> name="cdn__azure__container" value="<?php echo esc_attr( $this->_config->get_string( 'cdn.azure.container' ) ); ?>" size="30" />
		<input id="cdn_create_container" <?php Util_Ui::sealing_disabled( 'cdn.' ); ?> class="button {type: 'azure', nonce: '<?php echo esc_attr( wp_create_nonce( 'w3tc' ) ); ?>'}" type="button" value="<?php esc_attr_e( 'Create container', 'w3-total-cache' ); ?>" />
		<span id="cdn_create_container_status" class="w3tc-status w3tc-process"></span>
	</td>
</tr>
<tr>
	<th>
		<label for="cdn_azure_ssl">
			<?php
			echo wp_kses(
				sprintf(
					// translators: 1 opening HTML acronym tag, 2 closing HTML acronym tag.
					__(
						'%1$sSSL%2$s support:',
						'w3-total-cache'
					),
					'<acronym title="' . __( 'Secure Sockets Layer', 'w3-total-cache' ) . '">',
					'</acronym>'
				),
				array(
					'acronym' => array(
						'title' => array(),
					),
				)
			);
			?>
		</label>
	</th>
	<td>
		<select id="cdn_azure_ssl" name="cdn__azure__ssl" <?php Util_Ui::sealing_disabled( 'cdn.' ); ?>>
			<option value="auto"<?php selected( $this->_config->get_string( 'cdn.azure.ssl' ), 'auto' ); ?>><?php esc_html_e( 'Auto (determine connection type automatically)', 'w3-total-cache' ); ?></option>
			<option value="enabled"<?php selected( $this->_config->get_string( 'cdn.azure.ssl' ), 'enabled' ); ?>><?php esc_html_e( 'Enabled (always use SSL)', 'w3-total-cache' ); ?></option>
			<option value="disabled"<?php selected( $this->_config->get_string( 'cdn.azure.ssl' ), 'disabled' ); ?>><?php esc_html_e( 'Disabled (always use HTTP)', 'w3-total-cache' ); ?></option>
		</select>
		<p class="description">
			<?php
			echo wp_kses(
				sprintf(
					// translators: 1 opening HTML acronym tag, 2 closing HTML acronym tag,
					// translators: 3 opening HTML acronym tag, 4 closing HTML acronym tag.
					__(
						'Some %1$sCDN%2$s providers may or may not support %3$sSSL%4$s, contact your vendor for more information.',
						'w3-total-cache'
					),
					'<acronym title="' . __( 'Content Delivery Network', 'w3-total-cache' ) . '">',
					'</acronym>',
					'<acronym title="' . __( 'Secure Sockets Layer', 'w3-total-cache' ) . '">',
					'</acronym>'
				),
				array(
					'acronym' => array(
						'title' => array(),
					),
				)
			);
			?>
		</p>
	</td>
</tr>
<tr>
	<th><?php esc_html_e( 'Replace site\'s hostname with:', 'w3-total-cache' ); ?></th>
	<td>
		<?php
		$cdn_azure_user = $this->_config->get_string( 'cdn.azure.user' );
		$blobStorageUrlEnv = getenv('BLOB_STORAGE_URL');

		if ( '' !== $cdn_azure_user ) {
			if ($blobStorageUrlEnv !== false && preg_match('/blob.core.usgovcloudapi.net/', $blobStorageUrlEnv)) {
				echo esc_attr($cdn_azure_user) . '.blob.core.usgovcloudapi.net';
			} elseif ($blobStorageUrlEnv !== false && preg_match('/blob.core.chinacloudapi.cn/', $blobStorageUrlEnv)) {
				echo esc_attr($cdn_azure_user) . '.blob.core.chinacloudapi.cn';
			} else {
				echo esc_attr($cdn_azure_user) . '.blob.core.windows.net';
			}
		} else {
			if ($blobStorageUrlEnv !== false && preg_match('/blob.core.usgovcloudapi.net/', $blobStorageUrlEnv)) {
				echo '&lt;account name&gt;.blob.core.usgovcloudapi.net';
			} elseif ($blobStorageUrlEnv !== false && preg_match('/blob.core.chinacloudapi.cn/', $blobStorageUrlEnv)) {
				echo '&lt;account name&gt;.blob.core.chinacloudapi.cn';
			} else {
				echo '&lt;account name&gt;.blob.core.windows.net';
			}
		}

		echo wp_kses(
			sprintf(
				// translators: 1 opening HTML acronym tag, 2 closing HTML acronym tag.
				__(
					' or %1$sCNAME%2$s:',
					'w3-total-cache'
				),
				'<acronym title="' . __( 'Canonical Name', 'w3-total-cache' ) . '">',
				'</acronym>'
			),
			array(
				'acronym' => array(
					'title' => array(),
				),
			)
		);

		$cnames = $this->_config->get_array( 'cdn.azure.cname' );
		require W3TC_INC_DIR . '/options/cdn/common/cnames.php';
		?>
	</td>
</tr>
<tr>
	<th colspan="2">
		<input id="cdn_test" class="button {type: 'azure', nonce: '<?php echo esc_attr( wp_create_nonce( 'w3tc' ) ); ?>'}" type="button" value="<?php esc_attr_e( 'Test Microsoft Azure Storage upload', 'w3-total-cache' ); ?>" /> <span id="cdn_test_status" class="w3tc-status w3tc-process"></span>
	</th>
</tr>
