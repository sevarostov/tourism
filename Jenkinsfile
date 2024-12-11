stage('Unit Tests') {
    steps {
        sh 'vendor/bin/phpunit'
        xunit([
            thresholds: [
                failed ( failureThreshold: "0" ),
                skipped ( unstableThreshold: "0" )
            ],
            tools: [
                PHPUnit(pattern: 'build/logs/junit.xml', stopProcessingIfError: true, failIfNotNew: true)
            ]
        ])
        publishHTML([
            allowMissing: false,
            alwaysLinkToLastBuild: false,
            keepAll: false,
            reportDir: 'build/coverage',
            reportFiles: 'index.html',
            reportName: 'Coverage Report (HTML)',
            reportTitles: ''
        ])
        publishCoverage adapters: [coberturaAdapter('build/logs/cobertura.xml')]
    }
}