<div class="container">
	<header class="jumbotron subhead" id="overview">
		<h1>Setup</h1>
		<p class="lead">
			STARRS is designed to handle a variety of different network setups and reduce administrative overhead. These are the basic objects that you as an administrator need to configure for a new installation. After configuring one or more of each object, proceed on to the next. Attempting to configure objects out of order will result in errors.
		</p>
	</header>
	<section id="siteconfig">
		<div class="page-header">
			<h1>Site Configuration 
				<small>Make STARRS fit your needs</small>
			</h1>
		</div>
		<div class="container">
			There are several key variables that you need to configure to make your installation work. You can find these under Management->Configuration on the navigation bar. Once you have configured these, you can proceed with the basic setup. Failure to configure these variables will result in unintended operation as many key functions depend on them.
		</div>
	</section>
	<section id="groups">
		<div class="page-header">
			<h1>Groups
				<small>User management</small>
			</h1>
		</div>
		<div class="container">
			Users of STARRS can be a member of multiple groups. Each group may have different configuration options. A default ADMIN and USER group should be specified to allow for users to be easily authenticated. Alternatively an LDAP source may be used.
		</div>
	</section>
	<section id="datacenters">
		<div class="page-header">
			<h1>Datacenters
				<small>Regional locations that contain your resources</small>
			</h1>
		</div>
		<div class="container">
			Your systems and subnets that STARRS controls will be assigned to one or more datacenters within your organization. Datacenters act as logical containers and can allow you to more accurately organize your resources.
		</div>
	</section>
	<section id="availabilityzones">
		<div class="page-header">
			<h1>Availability Zones
				<small>Areas within your datacenters</small>
			</h1>
		</div>
		<div class="container">
			Datacenters are broken into several different Availability Zones. These allow you to further classify your resources depending on other organizational criteria. For example, some systems might be in a Production AZ while others are located in a Development AZ.
		</div>
	</section>
	<section id="vlans">
		<div class="page-header">
			<h1>VLANs
				<small>Layer-2 networks</small>
			</h1>
		</div>
		<div class="container">
			Your hosts in a datacenter are broken up into multiple VLANs across your switching infrastructure. STARRS will track your VLANs so you know where devices are in your network. You can also view switchport assignments and CAM tables based on the VLANs you configure.
		</div>
	</section>
	<section id="keys">
		<div class="page-header">
			<h1>DNS Keys
				<small>Perform DDNS updates on your zones</small>
			</h1>
		</div>
		<div class="container">
			To manage your DNS zones, STARRS uses TSIG keys to send updates to your authoritative nameservers. This allows for easy one-stop management of DNS records in your zones. Users can even create certain records for their own systems if their application depends on them.
		</div>
	</section>
	<section id="zones">
		<div class="page-header">
			<h1>DNS Zones
				<small>Automatically manage your records</small>
			</h1>
		</div>
		<div class="container">
			DNS zones are regions of the DNS namespace that you have authority over. Should you wish, STARRS can be configured to send DDNS updates to your authoritative nameserver to add new records.
		</div>
	</section>
	<section id="subnets">
		<div class="page-header">
			<h1>Subnets
				<small>Provision IP resources for users</small>
			</h1>
		</div>
		<div class="container">
			This is the core resource that STARRS controls. Your subnets are assigned to datacenters, with ranges of IP addresses assigned to Availability Zones. System Interfaces are then configured with addresses from your available subnets. 
		</div>
	</section>
	<section id="classes">
		<div class="page-header">
			<h1>DHCP Classes
				<small>Give your clients extra options</small>
			</h1>
		</div>
		<div class="container">
			DHCP classes allow you to configure additional options for clients. For example, an address configured with a class of 'pxeboot' might be able to PXE boot and deploy a new system without any user intervention.
		</div>
	</section>
	<section id="ranges">
		<div class="page-header">
			<h1>Ranges
				<small>Control resources in your availability zones</small>
			</h1>
		</div>
		<div class="container">
			IP ranges are sections of subnet address space that are logically seperated within your organization. Ranges allow you to easily group hosts together and assign certain options to them.
		</div>
	</section>
</div>
