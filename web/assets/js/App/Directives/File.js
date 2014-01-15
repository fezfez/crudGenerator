GeneratorApp.directive('fileTree', function ($compile) {
    return {
        template: '<ul><file></file></ul>',
        replace: true,
        restrict: 'E',
        scope: {
        	family: '=',
            fileView: '&'
        },
        link: function(scope, element, attrs) {
            var template = this.template;

            scope.$watch('family', function(fileList, old) {
                if (angular.isObject(fileList)) {
                    element.html(template);
                    $compile(element.contents())(scope);
                } else if(null === fileList) {
                    angular.element(element).hide();
                }
            });
        }
    };
});

angular.module('GeneratorApp.directives', [])
.directive('file', function ($compile) {
    return {
        restrict: 'E',
        template: '<li ng-repeat="file in family.getFiles()">' +
            '<span ng-click="fileView({fileObject : file})">{{ file.getName() }}</span>' +
            '</li>',
        link: function (scope, elm, attrs) {
        	var template = '<li ng-repeat="child in family.getChildren()">'+
                '<span class="directory">{{ child.getName() }}</span>' +
                '<file-tree family="child" file-view="fileView({fileObject : fileObject})"></file-tree>' +
            '</li>';

            //Add children by $compiling and doing a new file directive
            if (scope.family !== undefined && scope.family.getChildren().length > 0) {
                var childfile = $compile(template)(scope);
                elm.append(childfile);
            }
        }
    };
});