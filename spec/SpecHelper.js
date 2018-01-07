beforeEach(function () {
    // Set Debug Mode to Unit Testing
    window.DBG_MODE = 2;

    jasmine.addMatchers({
        toBePlaying: function () {
            return {
                compare: function (actual, expected) {
                    var player = actual;

                    return {
                        pass: player.currentlyPlayingSong === expected && player.isPlaying
                    };
                }
            };
        }
    });
});

function waitFor(stmt, callback) {
    var checkExist = setInterval(function() {
        if (eval(stmt)) {
            clearInterval(checkExist);
            callback();
        }
    }, 100);
}