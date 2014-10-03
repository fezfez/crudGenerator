define(
    ['Angular', 'AngularMock', "Corp/Directory/DirectoryDataObject", 'Corp/Context/Context', 'Services/GeneratorService'], 
    function(angular, mock, DirectoryDataObject, Context)
{
    describe('Testing GeneratorService', function() {

        var httpBackend = undefined, _GeneratorService_ = undefined;

        beforeEach((function() {
            angular.mock.module('GeneratorApp');
            angular.mock.inject(function(GeneratorService, $httpBackend) {
                // Set up the mock http service responses
                httpBackend        = $httpBackend;
                _GeneratorService_ = GeneratorService;
            });
        }));
        
        it('Should throw exception on wrong context type', function() {
            expect(function() {
                _GeneratorService_.build("im wrong", false, function(context) {}, function(error) {});
            }).toThrow();
        });
        
        it('Should set metadatanocache to true if undefined', function() {
        	httpBackend.expectPOST('generator').respond(200, '');
            _GeneratorService_.build(new Context(), undefined, function(context) {}, function(error) {});
        });
        
        it('Should throw exception on wrong metadata_nocache type', function() {
            expect(function() {
            	_GeneratorService_.build(new Context(), 'im wrong', function(context) {}, function(error) {});
            }).toThrow();
        });
        
        it('Should throw exception on wrong callBackAfterAjax type', function() {
            expect(function() {
            	_GeneratorService_.build(new Context(), false, "im wrong", function(error) {});
            }).toThrow();
        });
        
        it('Should throw exception on wrong callbackError type', function() {
            expect(function() {
            	_GeneratorService_.build(new Context(), false, function(context) {}, "im wrong");
            }).toThrow();
        });

        it('should preview generation', function() {

            httpBackend.whenPOST("generator").respond(
                {
                    'generator' : {
                        'files' : [
                            {
                                'fileName' : 'test'
                            }
                        ],
                        'questions' : {}
                    }
                }
            );

            _GeneratorService_.build(
                new Context(),
                false,
                function(directories) {
                    expect(directories instanceof Context).toBe(true);
                }, function(error) {
                    
                }
            );
            httpBackend.flush();
        });

        it('Should return error', function() {

            var errorString = 'MyError !';
            httpBackend.expectPOST('generator').respond(500, {error : errorString});

            _GeneratorService_.build(
                new Context(),
                false,
                function(directories) {
                    expect(directories instanceof Context).toBe(true);
                }, function(error) {
                    expect(error).toBe(errorString);
                }
            );
            httpBackend.flush();
        });

        afterEach(function() {
            httpBackend.verifyNoOutstandingExpectation();
        });
    });
});