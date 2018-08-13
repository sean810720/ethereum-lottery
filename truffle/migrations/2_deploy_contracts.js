/*
var SimpleStorage = artifacts.require("./SimpleStorage.sol");

module.exports = function(deployer) {
  deployer.deploy(SimpleStorage);
};
*/

var Lottery = artifacts.require("./Lottery.sol");

module.exports = function(deployer) {
  deployer.deploy(Lottery);
};
