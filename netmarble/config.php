<?PHP
class Netmarble_Config {
	public $reqs = array(
		'accountlist' => array(
			'endpoint' => 'common/account/list',
			'args' => array(
				'channelCode' => array(
					'vartype' => 'str',
					'example' => '003'
				),
				'channelUserIdList' => array(
					'vartype' => 'str',
					'example' => '01234567890~12345',
					'special' => 'takes_array'
				)
			)
		),
		'info' => array(
			'endpoint' => 'common/setting/info',
			'args' => array()
		),
		'account' => array(
			'endpoint' => 'common/v2/account/set',
			'args' => array(
				'channelCode' => array(
					'vartype' => 'str',
					'example' => '003'
				),
				'channelUserId' => array(
					'vartype' => 'str',
					'example' => '123456~234321',
				),
				'nickName' => array(
					'vartype' => 'str',
					'example' => 'sakiski'
				),
				'profileUrl' => array(
					'vartype' => 'str',
					'example' => 'http://example.com'
				),
				'ticketPresentRejectFlag' => array(
					'vartype' => 'bool',
					'example' => 'false [true causes deletion]'
				),
				'gameWithdrawFlag' => array(
					'vartype' => 'bool',
					'example' => 'false'
				),
				'extraInfo' => array(
					'vartype' => 'str',
					'example' => 'json-literal'
				)
			)
		),
		'increment' => array(
			'endpoint' => 'common/v2/score/increase',
			'args' => array(
				'channelCode' => array(
					'vartype' => 'str',
					'example' => '003'
				),
				'channelUserId' => array(
					'vartype' => 'int',
					'example' => '123456~234321'
				),
				'rankMode' => array(
					'vartype' => 'str',
					'example' => '101'
				),
				'score' => array(
					'vartype' => 'int',
					'example' => '58383'
				),
				'extraInfo' => array(
					'vartype' => 'str',
					'example' => 'foo bar baz'
				)
			)
		), //score/increase
		'score' => array(
			'endpoint' => 'common/score/info',
			'args' => array(
				'channelCode' => array(
					'vartype' => 'str',
					'example' => '003'
				),
				'channelUserId' => array(
					'vartype' => 'int',
					'example' => '01234567890~12345'
				),
				'season' => array(
					'vartype' => 'int',
					'example' => '0'
				),
			)
		), //score/info
		'global' => array(
			'endpoint' => 'ranking/global/list',
			'args' => array(
				'channelCode' => array(
					'vartype' => 'str',
					'example' => '003'
				),
				'rankMode' => array(
					'vartype' => 'str',
					'example' => '001'
				),
				'range' => array(
					'vartype' => 'str',
					'example' => '0-99',
					'special' => 'range'
				),
				'season' => array(
					'vartype' => 'int',
					'example' => '-1'
				),
			)
		)
	);
}