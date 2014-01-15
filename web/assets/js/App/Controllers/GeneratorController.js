(function () {
    "use strict";

    angular.module('GeneratorApp.controllers', [])
         .controller("GeneratorCtrl", ['$scope', '$http', 'GeneratorService', 'ViewFileService',
                                              function ($scope, $http, $generatorService, $viewFileService) {
                $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

                $http.get('list-backend').success(function (data) {
                    $scope.backendList = data.backend;
                });

                $scope.backendChange = function () {
                    var datas =  $.param({backend: $scope.backEnd});
                    $http(
                        {
                            headers : {'Content-Type': 'application/x-www-form-urlencoded'},
                            method  : 'POST',
                            url     : 'metadata',
                            data    : datas
                        }
                    ).success(function (data) {
                        if (data.config !== undefined) {
                            $('#configuration-modal .modal-body').empty();
                            $('#configuration-modal .modal-body').append(msg.config);
                            $('#configuration-modal').modal('show');
                            $("#configuration-modal form").submit(function (){
                                $.ajax({
                                    type : "POST",
                                    data : $(this).serialize() + '&' + $('#form_Backend').serialize(),
                                    url  : $(this).attr('action')
                                }).done(function (data) {
                                    if (data.error !== undefined) {
                                        $('#alert-config').remove();
                                        $("#configuration-modal .modal-body").prepend('<div id="alert-config" class="alert alert-danger fade in">' + data.error + '</div>');
                                    } else {
                                        $('#configuration-modal').modal('hide');
                                    }
                                });
                                return false;
                            });
                        } else if (data.metadatas !== undefined) {
                            $scope.metadataList = data.metadatas;

                            $http.get('list-generator').success(function (data) {
                                $scope.generatorsList = data.generators;
                            });
                        }
                    });
                };

                $scope.handleGenerator = function (generatorName, oldGeneratorName) {
                    var datas =  $.param({
                        backend   : $scope.backEnd,
                        generator : generatorName,
                        metadata  : $scope.metadata,
                        questions : $('.questions').serialize()
                    });

                    $generatorService.build(datas, function (directories, questionList) {
                        $scope.fileList = directories;
                        if (generatorName !== oldGeneratorName) {
                            $scope.questionsList = questionList;
                        }
                    });
                };

                $scope.$watch('generators', function (generatorName, oldGeneratorName) {
                    if (generatorName !== undefined) {
                        $scope.handleGenerator(generatorName, oldGeneratorName);
                    }
                });

                $scope.viewFile = function (file) {
                	console.log(arguments);
                    var datas = $.param({
                        generator    : $scope.generators,
                        skeletonPath : file.getSkeletonPath(),
                        file         : file.getOriginalName(),
                        backend      : $scope.backEnd,
                        metadata     : $scope.metadata,
                        questions    : $('.questions').serialize()
                    });

                    $viewFileService.generate(datas, function (results) {
                        $scope.modal = {
                            'title' : file.getName(),
                            'body' : '<pre class="brush: php;">' + results.generator + '<pre>',
                            'callback' : function () {
                                SyntaxHighlighter.highlight();
                            }
                        };
                    });
                };
            }]);
}());