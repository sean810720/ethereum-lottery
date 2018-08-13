pragma solidity ^0.4.22;


contract Lottery {

    // 莊家
    address public owner;

    // 玩家
    address[] public players;

    constructor() public
    {
        // 合約發布者為莊家
        owner = msg.sender;
    }

    // 下注
    function enter() public payable
    {
        require(msg.value > .0001 ether);
        players.push(msg.sender);
    }

    // 產生隨機整數
    function random() private view returns (uint)
    {
        return uint(keccak256(abi.encodePacked(block.difficulty, now, players)));
    }

    // 限制只能由莊家執行
    modifier ownerOnly ()
    {
        require(msg.sender == owner);
        _;
    }

    // 莊家選擇贏家
    function pickWinner() public ownerOnly
    {
        uint index = random() % players.length;
        players[index].transfer(address(this).balance);
        players = new address[](0);
    }

    // 回傳目前玩家名單
    function getPlayers() public view returns (address[])
    {
        return players;
    }
}
