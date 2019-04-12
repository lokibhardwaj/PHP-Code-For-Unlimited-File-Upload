
<div class="footer">	
   <a href="<?php echo rtrim($cfg['web_root'], '/');?>">
	<div class="footer-logo" id="footer-logo"></div>
	</a>
	<div id="copyright">
		<p>
			<br />
			<a href="https://www.gnu.org/licenses/agpl.html"><abbr title="Affero General Public License">AGPL</abbr>v3</a> |
			<!--<a href="https://gitlab.com/mojo42/Jirafeau"><?php echo t('About') ?></a> |-->
			<a href="<?php echo rtrim($cfg['web_root'], '/') . '/tos.php'; ?>"><?php echo t('Terms') ?></a>
			<?php if(isset($_SESSION['login_auth']) && $_SESSION['login_auth'] ==true){?>
			<span class="footer-logout">
			| <a href="<?php echo rtrim($cfg['web_root'], '/') . '/logout.php'; ?>"><?php echo t('Logout') ?></a>
			</span>
			<?php } ?>
			
		</p>
	</div>
</div>	<!--footer ends-->

</div>
<div id="jyraphe">
</div>
</body>
</html>
